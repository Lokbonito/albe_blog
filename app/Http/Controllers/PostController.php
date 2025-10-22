<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\Category;
use App\Models\Post;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class PostController extends Controller
{
    public function addPost(Request $request)
    {
        $categories_html = '';
        $pcategories = ParentCategory::whereHas('children')->orderBy('name', 'asc')->get();
        $categories = Category::where('parent', 0)->orderBy('name', 'asc')->get();

        if (count($pcategories) > 0) {
            foreach ($pcategories as $item) {
                $categories_html .= '<optgroup label="' . $item->name . '">';
                foreach ($item->children as $category) {
                    $categories_html .= '<option value="' . $category->id . '">' . $category->name . '</option>';
                }
                $categories_html .= '</optgroup>';
            }
        }

        if (count($categories) > 0) {
            foreach ($categories as $item) {
                $categories_html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }

        $data = [
            'pageTitle' => 'Thêm bài viết với',
            'categories_html' => $categories_html,
        ];

        return view('back.pages.add_post', $data);
    }

    public function createPost(Request $request)
    {
        // ✅ Bước 1: Validate dữ liệu đầu vào
        $request->validate([
            'title' => 'required|unique:posts,title',
            'content' => 'required',
            'category' => 'required|exists:categories,id',
            'featured_image' => 'required|mimes:png,jpg,jpeg|max:1024',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại, vui lòng chọn tiêu đề khác.',

            'content.required' => 'Vui lòng nhập nội dung bài viết.',

            'category.required' => 'Vui lòng chọn danh mục cho bài viết.',
            'category.exists' => 'Danh mục đã chọn không tồn tại trong hệ thống.',

            'featured_image.required' => 'Vui lòng tải lên hình ảnh đại diện cho bài viết.',
            'featured_image.mimes' => 'Hình ảnh phải có định dạng PNG, JPG hoặc JPEG.',
            'featured_image.max' => 'Kích thước hình ảnh không được vượt quá 1MB.',
        ]);

        // ✅ Bước 2: Kiểm tra và xử lý khi có ảnh upload
        if ($request->hasFile('featured_image')) {
            $path = "images/posts/"; // Thư mục lưu ảnh gốc
            $file = $request->file("featured_image");
            $filename = $file->getClientOriginalName(); // Lấy tên file gốc
            $new_filename = time() . '-' . $filename; // Đặt lại tên file để tránh trùng

            // ✅ Bước 3: Upload file ảnh vào thư mục public/images/posts
            $upload = $file->move(public_path($path), $new_filename);

            if ($upload) {
                // ✅ Bước 4: Lưu dữ liệu bài viết vào database
                $post = new Post();
                $post->author_id = auth()->id(); // ID tác giả
                $post->category = $request->category; // Danh mục bài viết
                $post->title = $request->title; // Tiêu đề bài viết
                $post->content = $request->content; // Nội dung bài viết
                $post->featured_image = $new_filename; // Tên file ảnh đại diện
                $post->tags = $request->tags; // Thẻ bài viết (nếu có)
                $post->meta_keywords = $request->meta_keywords; // SEO keywords
                $post->meta_description = $request->meta_description; // SEO description
                $post->visibility = $request->visibility; // Trạng thái hiển thị
                $saved = $post->save();

                // ✅ Bước 5: Trả về phản hồi JSON tùy theo kết quả lưu
                if ($saved) {
                    return response()->json(['status' => 1, 'message' => 'Thêm bài viết mới thành công']);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Có lỗi xảy ra khi lưu bài viết']);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Upload hình ảnh thất bại']);
            }
        }
    }


    public function allPosts(Request $request)
    {
        $data = [
            'pageTitle' => 'Danh sách bài viết',
        ];

        return view('back.pages.posts', $data);
    }

    public function editPost(Request $request, $id = null)
    {
        $post = Post::findOrFail($id);

        $categories_html = '';
        $pcategories = ParentCategory::whereHas('children')->orderBy('name', 'asc')->get();
        $categories = Category::where('parent', 0)->orderBy('name', 'asc')->get();

        if (count($pcategories) > 0) {
            foreach ($pcategories as $item) {
                $categories_html .= '<optgroup label="' . $item->name . '">';
                foreach ($item->children as $category) {
                    $selected = $category->id == $post->category ? 'selected' : '';
                    $categories_html .= '<option value="' . $category->id . '" ' . $selected . '>' . $category->name . '</option>';
                }
                $categories_html .= '</optgroup>';
            }
        }

        if (count($categories) > 0) {
            foreach ($categories as $item) {
                $selected = $item->id == $post->category ? 'selected' : '';
                $categories_html .= '<option value="' . $item->id . '" ' . $selected . '>' . $item->name . '</option>';
            }
        }

        $data = [
            'pageTitle' => 'Edit',
            'post' => $post,
            'categories_html' => $categories_html
        ];

        return view('back.pages.edit_post', $data);
    }

    public function updatePost(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $featured_image_name = $post->featured_image;

        // Validate dữ liệu nhập vào
        $request->validate([
            'title' => 'required|unique:posts,title,' . $post->id,
            'content' => 'required',
            'category' => 'required|exists:categories,id',
            'featured_image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'title.unique' => 'Tiêu đề bài viết này đã tồn tại, vui lòng chọn tiêu đề khác.',

            'content.required' => 'Vui lòng nhập nội dung bài viết.',

            'category.required' => 'Vui lòng chọn danh mục cho bài viết.',
            'category.exists' => 'Danh mục đã chọn không tồn tại trong hệ thống.',

            'featured_image.mimes' => 'Hình ảnh phải có định dạng JPEG, JPG hoặc PNG.',
            'featured_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ]);

        // Nếu có file ảnh mới được upload
        if ($request->hasFile('featured_image')) {
            $old_featured_image = $post->featured_image;
            $path = 'images/posts/';

            // Đảm bảo thư mục tồn tại
            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true);
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Lưu ảnh gốc
            $file->move(public_path($path), $filename);

            // Xóa ảnh cũ nếu có
            if ($old_featured_image && File::exists(public_path($path . $old_featured_image))) {
                File::delete(public_path($path . $old_featured_image));
            }

            $featured_image_name = $filename;
        }

        // Cập nhật dữ liệu bài viết
        $post->category = $request->category;
        $post->title = $request->title;
        $post->slug = null; // để Sluggable tự sinh lại
        $post->content = $request->content;
        $post->featured_image = $featured_image_name;
        $post->tags = $request->tags;
        $post->meta_keywords = $request->meta_keywords;
        $post->meta_description = $request->meta_description;
        $post->visibility = $request->visibility;

        $saved = $post->save();

        if ($saved) {
            return response()->json(['status' => 1, 'message' => 'Bài viết đã được cập nhật thành công']);
        }

        return response()->json(['status' => 0, 'message' => 'Có lỗi xảy ra']);
    }
}
