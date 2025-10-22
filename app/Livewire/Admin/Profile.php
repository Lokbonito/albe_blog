<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helpers\CMail;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';

    protected $queryString = ['tab' => ['keep' => true]];

    public $name, $email, $username, $bio;

    public $current_password, $new_password, $new_password_confirmation;

    // Các thuộc tính mới cho quy trình OTP
    public $otp;
    public $showOtpInput = false;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;
        $user = User::findOrFail(auth()->id());
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->bio = $user->bio;
    }

    public function updatePersonalDetail()
    {
        $user = User::findOrFail(auth()->id());
        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id
        ]);

        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;
        $updated = $user->save();
        sleep(0.5);

        if ($updated) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Thông tin tài khoản đã được cập nhật']);
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra']);
        }
    }

    /**
     * Bước 1: Xác thực mật khẩu hiện tại/mới và gửi mã OTP.
     * Hàm này được gọi khi người dùng nhấn nút "Cập nhật mật khẩu" ban đầu.
     */
    public function sendUpdatePasswordOtp()
    {
        $user = User::findOrFail(auth()->id());
        $this->validate([
            'current_password' => [
                'required',
                'min:8',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('Mật khẩu hiện tại không khớp'));
                    }
                }
            ],
            'new_password' => 'required|min:8|confirmed'
        ], [
            'current_password.required' => 'Yêu cầu nhập mật khẩu hiện tại',
            'current_password.min' => 'Độ dài mật khẩu tối thiểu 8 ký tự',
            'new_password.required' => 'Yêu cầu nhập mật khẩu mới',
            'new_password.min' => 'Độ dài mật khẩu mới tối thiểu 8 ký tự',
            'new_password.confirmed' => 'Mật khẩu không trùng khớp'
        ]);

        // Tạo và gửi OTP
        $otp = rand(100000, 999999);

        // Lưu trữ OTP, thời gian hết hạn và mật khẩu mới vào session
        session([
            'password_update_otp' => $otp,
            'password_update_otp_expires_at' => now()->addMinutes(5), // OTP hết hạn sau 5 phút
            'new_password_for_update' => $this->new_password
        ]);

        // Gửi email chứa OTP
        $mail_body = view('email-templates.otp-template', [
            'user' => $user,
            'otp' => $otp,
        ])->render();

        $mail_config = [
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Mã OTP Cập Nhật Mật Khẩu',
            'body' => $mail_body
        ];

        if (CMail::send($mail_config)) {
            $this->showOtpInput = true; // Hiển thị ô nhập OTP trên giao diện
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Mã OTP đã được gửi đến email của bạn.']);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Không thể gửi OTP. Vui lòng thử lại.']);
        }
    }

    /**
     * Bước 2: Xác minh OTP và hoàn tất việc cập nhật mật khẩu.
     * Hàm này thay thế cho hàm updatePassword ban đầu.
     */
    public function updatePassword()
    {
        $this->validate([
            'otp' => 'required|digits:6'
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.digits' => 'Mã OTP phải có 6 chữ số.'
        ]);

        // Kiểm tra dữ liệu OTP trong session có tồn tại không
        if (!session()->has('password_update_otp') || !session()->has('password_update_otp_expires_at') || !session()->has('new_password_for_update')) {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Yêu cầu đã hết hạn. Vui lòng thử lại.']);
            $this->resetForm();
            return;
        }

        // Kiểm tra OTP đã hết hạn chưa
        if (now()->isAfter(session('password_update_otp_expires_at'))) {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Mã OTP đã hết hạn.']);
            $this->resetForm();
            return;
        }

        // Kiểm tra OTP có chính xác không
        if ($this->otp != session('password_update_otp')) {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Mã OTP không chính xác.']);
            return;
        }

        // --- Mọi kiểm tra đã hợp lệ, tiến hành cập nhật mật khẩu ---
        $user = User::findOrFail(auth()->id());
        $newPassword = session('new_password_for_update');

        $updated = $user->update([
            'password' => Hash::make($newPassword)
        ]);

        if ($updated) {
            // Gửi email thông báo mật khẩu đã thay đổi
            $data = array(
                'user' => $user,
                'new_password' => $newPassword
            );
            $mail_body = view('email-templates.password-changes-template', $data)->render();
            $mail_config = array(
                'recipient_address' => $user->email, // Sửa từ $user->mail thành $user->email
                'recipient_name' => $user->name,
                'subject' => 'Mật khẩu đã được thay đổi',
                'body' => $mail_body
            );
            CMail::send($mail_config);

            // Dọn dẹp session
            $this->resetForm();

            // Đăng xuất và chuyển hướng
            auth()->logout();
            Session::flash('info', 'Cập nhật mật khẩu thành công. Vui lòng đăng nhập lại.');
            $this->redirectRoute('admin.login', navigate: true);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Có lỗi xảy ra, không thể cập nhật mật khẩu.']);
        }
    }

    /**
     * Hàm hỗ trợ để reset trạng thái của form.
     */
    public function resetForm()
    {
        session()->forget(['password_update_otp', 'password_update_otp_expires_at', 'new_password_for_update']);
        $this->current_password = null;
        $this->new_password = null;
        $this->new_password_confirmation = null;
        $this->otp = null;
        $this->showOtpInput = false;
    }


    public function render()
    {
        return view('livewire.admin.profile', [
            'user' => User::findOrFail(auth()->id())
        ]);
    }
}
