<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\UserStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Helpers\CMail;


class AuthController extends Controller
{
    public function loginForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Login',

        ];

        return view('back.pages.auth.login', $data);
    }

    public function forgotForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot Password',
        ];
        return view('back.pages.auth.forgot', $data);
    }

    public function resetForm(Request $request, $token = null)
    {
        $isTokenExists = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$isTokenExists) {
            return redirect()->route('admin.forgot')
                ->with('fail', 'Token không hợp lệ. Vui lòng gửi yêu cầu cài lại mật khẩu mới');
        }

        // Check if token is expired (older than 15 minutes)
        $diffMins = Carbon::parse($isTokenExists->created_at)->diffInMinutes(now());
        if ($diffMins > 15) {
            return redirect()->route('admin.forgot')
                ->with('fail', 'Token đã hết hạn. Vui lòng gửi yêu cầu cài lại mật khẩu mới');
        }

        $data = [
            'pageTitle' => 'Reset Password',
            'token' => $token,
        ];

        return view('back.pages.auth.reset', $data);
    }

    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required|min:8',
        ], [
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.required_with' => 'Vui lòng nhập lại mật khẩu xác nhận.',
            'new_password.same' => 'Mật khẩu xác nhận không trùng khớp.',

            'new_password_confirmation.required' => 'Vui lòng nhập mật khẩu xác nhận.',
            'new_password_confirmation.min' => 'Mật khẩu xác nhận phải có ít nhất 8 ký tự.',
        ]);


        $dbToken = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();


        $user = User::where('email', $dbToken->email)->first();

        User::where('email', $user->email)
            ->update([
                'password' => Hash::make($request->new_password)
            ]);

        $data = array(
            'user' => $user,
            'new_password' => $request->new_password
        );

        $mail_body = view('email-templates.password-changes-template', $data)->render();

        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Mật khẩu đã được thay đổi',
            'body' => $mail_body,
        );

        if (Cmail::send($mailConfig)) {
            DB::table('password_reset_tokens')->where([
                'email' => $dbToken->email,
                'token' => $dbToken->token
            ])->delete();

            return redirect()->route('admin.login')->with('success', 'Cài lại mật khẩu thành công');
        } else {
            return redirect()->route('admin.reset_password_form', ['token' => $dbToken->token])->with('fail', 'Đã có lỗi xảy ra');
        }
    }

    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:8',
            ], [
                'login_id.required' => 'Vui lòng nhập địa chỉ email.',
                'login_id.email' => 'Địa chỉ email không hợp lệ.',
                'login_id.exists' => 'Email này chưa được đăng ký trong hệ thống.',

                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|string|exists:users,username',
                'password' => 'required|min:8',
            ], [
                'login_id.required' => 'Vui lòng nhập tên đăng nhập.',
                'login_id.string' => 'Tên đăng nhập phải là chuỗi ký tự hợp lệ.',
                'login_id.exists' => 'Tên đăng nhập không tồn tại trong hệ thống.',

                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            ]);
        }
        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password,

        );

        if (Auth::attempt($creds)) {
            //       Check if account is inactive mode
            if (auth()->user()->status == UserStatus::Inactive) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Tài khoản của bạn đang ngừng hoạt động. Vui lòng liên hệ quản trị viên');
            }

            if (auth()->user()->status == UserStatus::Pending) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Tài khoản của bạn đang trong hàng chờ xét duyệt. Vui lòng liên hệ quản trị viên');
            }

            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->withInput()->with('fail', 'Sai địa chỉ Email hoặc mật khẩu');
        }
    }

    public function SendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|string|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ Email hoặc tên người dùng',
            'email.email' => 'Địa chỉ Email không hợp lệ',
            'email.exists' => 'Không thể tìm được người dùng hợp lệ với địa chỉ Email đó',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = base64_encode(Str::random(64));

        $oldToken = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->first();

        if ($oldToken) {
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
        } else {
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        }

        $actionLink = route('admin.reset_password_form', ['token' => $token]);

        $data = array(
            'actionlink' => $actionLink,
            'user' => $user,
        );

        $mail_body = view('email-templates.forgot-template', $data)->render();

        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Reset Password',
            'body' => $mail_body,
        );

        if (CMail::send($mailConfig)) {
            return redirect()->route('admin.forgot')->with('success', 'Đã gửi đường dẫn cài đặt lại mật khẩu đến email');
        } else {
            return redirect()->route('admin.forgot')->with('fail', 'Có lỗi xảy ra');
        }
    }
}
