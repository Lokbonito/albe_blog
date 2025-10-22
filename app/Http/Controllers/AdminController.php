<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use SawaStacks\Utils\Kropify;

class AdminController extends Controller
{
    public function adminDashboard(Request $request)
    {
        $data = [
            'pageTitle' => 'Admin Dashboard',
        ];
        return view('back.pages.dashboard', $data);
    }

    public function logoutHandler(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('fail', 'Đăng xuất thành công');
    }

    public function profileView(Request $request)
    {
        $data = [
            'pageTitle' => 'Tài khoản',
        ];
        return view('back.pages.profile', $data);
    }


    public function updateProfilePicture(Request $request)
    {
        $user = User::findOrFail(auth()->id());
        $file = $request->file('profilePictureFile');
        $old_picture = $user->picture;
        $filename = 'IMG_' . uniqid() . '.png';

        $path = 'images/users/';
        $savePath = public_path($path);

        // Đảm bảo thư mục tồn tại
        if (!File::exists($savePath)) {
            File::makeDirectory($savePath, 0755, true);
        }

        // Di chuyển file vào thư mục đích
        $moved = $file->move($savePath, $filename);

        if ($moved) {
            // Xóa ảnh cũ nếu tồn tại
            if ($old_picture && File::exists($savePath . $old_picture)) {
                File::delete($savePath . $old_picture);
            }

            // Cập nhật DB
            $user->update(['picture' => $filename]);

            return response()->json(['status' => 1, 'message' => 'Cập nhật ảnh thành công']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Có lỗi xảy ra']);
        }
    }

    public function generalSettings(Request $request)
    {
        $data = [
            'pageTitle' => 'Cài đặt chung'
        ];
        return view('back.pages.general_settings', $data);
    }


    public function updateLogo(Request $request)
    {
        $settings = GeneralSetting::first();

        if (is_null($settings)) {
            return response()->json(['status' => 0, 'message' => 'Đảm bảo đã điền đầy đủ thông tin form']);
        }

        if (!$request->hasFile('site_logo')) {
            return response()->json(['status' => 0, 'message' => 'Chưa có logo được tải lên']);
        }

        $path = 'images/site/';
        $file = $request->file('site_logo');
        $filename = 'logo_' . uniqid() . '.png';
        $old_logo = $settings->site_logo;

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_logo && File::exists(public_path($path . $old_logo))) {
                File::delete(public_path($path . $old_logo));
            }

            $settings->update(['site_logo' => $filename]);

            return response()->json([
                'status' => 1,
                'image_path' => $path . $filename,
                'message' => 'Logo Site đã được cập nhật'
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Có lỗi xảy ra khi upload logo'
        ]);
    }

    public function updateFavicon(Request $request){
        $settings = GeneralSetting::take(1)->first();

        if(!is_null($settings)){
            $path = 'images/site';
            $old_favicon = $settings->site_favicon;
            $file = $request->file('site_favicon');
            $filename = 'favicon_'.uniqid().'.png';

            if($request->hasFile('site_favicon')){
                $upload = $file->move(public_path($path),$filename);

                if($upload){
                    if($old_favicon != null && File::exists(public_path($path.$old_favicon))){
                        File::delete(public_path($path.$old_favicon));
                    }

                    $settings->update(['site_favicon'=>$filename]);
                    return response()->json(['status'=>1,'message'=>'Favicon Site đã được cập nhật thành công','image_path'=>$path.$filename]);
                }else{
                    return response()->json(['status'=>0,'Có lỗi xảy ra khi upload favicon mới']);
                }
            }
        }else{
            return response()->json(['status'=>0,'message'=>'Đảm bảo bảo cập nhật tab cài đặt chung trước']);
        }
    }

    public function categoriesPage(){
        $data = [
            'pageTitle' => 'Quản lý Thể loại'
        ];

        return view('back.pages.categories_page',$data);
    }

    public function manageSlider(){
        $data = [
            'pageTitle' => 'Quản lý Slider'
        ];

        return view('back.pages.slider',$data);
    }

}
