<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Helpers\CMail;
use App\Models\GeneralSetting;



class BlogController extends Controller
{
    public function index(Request $request)
    {
        $title = isset(settings()->site_title) ? settings()->site_title : '';
        $description = isset(settings()->site_meta_description) ? settings()->site_meta_description : '';
        $imagURL = isset(settings()->site_logo) ? asset('/images/site' . settings()->site_logo) : '';
        $keywords = isset(settings()->site_meta_keywords) ? settings()->site_meta_keywords : '';
        $currentUrl = url()->current();

        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);

        SEOTools::opengraph()->setUrl($currentUrl);
        SEOTools::opengraph()->addImage($imagURL);
        SEOTools::opengraph()->addProperty('type', 'articles');

        SEOTools::twitter()->addImage($imagURL);
        SEOTools::twitter()->setUrl($currentUrl);
        SEOTools::twitter()->setSite('@larablog');
        $data = [
            'pageTitle' => $title
        ];

        return view('front.pages.index', $data);
    }

    public function categoryPosts(Request $request, $slug = null)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::where('category', $category->id)->paginate(6);

        $title = 'Bài viết trong:' . $category->name;
        $description = "Khám phá các bài viết mới nhất thuộc danh mục " . $category->name . ", nơi bạn có thể cập nhật bài viết, góc nhìn và hướng dẫn hữu ích.";

        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setUrl(url()->current());

        $data = [
            'pageTitle' => $category->name,
            'posts' => $posts,
            'category' => $category,
        ];
        return view('front.pages.category_posts', $data);
    }

    public function authorPosts(Request $request, $username = null)
    {
        $author = User::where('username', $username)->firstOrFail();

        //Retrieve posts related to this category and paginate
        $posts = Post::where('author_id', $author->id)->orderBy('created_at', 'asc')->paginate(8);
        $title = $author->name . ' - Blog Posts';
        $description = 'Explore the latest posts by ' . $author->name . ' on various topics';

        /** Set SEO Meta Tags */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::setCanonical(route('author_posts', ['username' => $author->username]));
        SEOTools::opengraph()->setUrl(route('author_posts', ['username' => $author->username]));
        SEOTools::opengraph()->addProperty('type', 'profile');
        SEOTools::opengraph()->setProfile([
            'first_name' => $author->name,
            'username' => $author->username
        ]);

        $data = [
            'pageTitle' => $author->name,
            'author' => $author,
            'posts' => $posts
        ];

        return view('front.pages.author_posts', $data);
    }

    public function tagPosts(Request $request, $tag = null)
    {
        // Query posts that have the selected tag
        $posts = Post::where('tags', 'LIKE', "%{$tag}%")
            ->where('visibility', 1)
            ->paginate(8);

        /** For Meta Tags */
        $title = "Bài viết có tag {$tag}";
        $description = "Khám phá tất cả bài viết với {$tag} tag tại blog của chúng tôi.";

        /** Set SEO Meta Tags */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');

        $data = [
            'pageTitle' => $title,
            'tag' => $tag,
            'posts' => $posts
        ];

        return view('front.page.tag_posts');
    }

    public function readPost(Request $request, $slug = null)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Get related posts
        $relatedPosts = Post::where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->where('visibility', 1)
            ->take(9)
            ->get();

        // Get the next post
        $nextPost = Post::where('id', '>', $post->id)
            ->where('visibility', 1)
            ->orderBy('id', 'asc')
            ->first();

        // Get the previous post
        $prevPost = Post::where('id', '<', $post->id)
            ->where('visibility', 1)
            ->orderBy('id', 'desc')
            ->first();

        // Set SEO Meta Tags
        $title = $post->title;
        $description = ($post->meta_description != '') ? $post->meta_description : words($post->content, 35);

        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setUrl(route('read_post', ['slug' => $post->slug]));
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::opengraph()->addImage(asset('images/posts/' . $post->featured_image));
        SEOTools::twitter()->setImage(asset('images/posts/' . $post->featured_image));

        $data = [
            'pageTitle' => $title,
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'nextPost' => $nextPost,
            'prevPost' => $prevPost
        ];

        return view('front.pages.single_post', $data);
    }

    public function contactPage(Request $request)
    {
        $title = 'Liên hệ';
        $description = 'Hate Forms? Write Us Email';
        SEOTools::setTitle($title, appendDefault: false);
        SEOTools::setDescription($description);

        return view('front.pages.contact');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'message' => 'required',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'phoneNumber.required' => 'Vui lòng nhập số điện thoại.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
        ]);


        $siteInfo = settings();

        $subject = 'Email từ khách hàng ' . $request->name;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'message' => $request->message,
            'recipient_name' => $siteInfo->site_title ?? 'Quản trị viên',
            'site_title' => $siteInfo->site_title ?? config('app.name'),
            'site_email' => $siteInfo->site_email ?? config('mail.from.address'),
            'admin_panel_link' => url('/admin/contact-messages'),
        ];

        $mail_body = view('email-templates.contact-message-template', $data)->render();

        if (substr($mail_body, 0, 3) === "\xEF\xBB\xBF") {
            $mail_body = substr($mail_body, 3);
        }

        $mail_body = mb_convert_encoding($mail_body, 'UTF-8', 'auto');
        $mail_body = trim($mail_body);

        $bodyToSend = $mail_body;
        $transferEncoding = '8bit';

        $mail_config = [
            'from_name' => $request->name,
            'replyToAddress' => $request->email,
            'replayToName' => $request->name,
            'recipient_address' => $siteInfo->site_email,
            'recipient_name' => $siteInfo->site_title,
            'subject' => $subject,
            'body' => $bodyToSend,
            'headers' => [
                'MIME-Version' => '1.0',
                'Content-Type' => 'text/html; charset=UTF-8',
                'Content-type' => 'text/html; charset=UTF-8',
                'Content-Transfer-Encoding' => $transferEncoding,
                'From' => "{$request->name} <{$request->email}>",
            ],
        ];

        // Gửi
        if (CMail::send($mail_config, true)) {
            return redirect()->back()->with('success', 'Email đã được gửi thành công');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra. Thử lại sau');
    }

    public function introduce()
    {
        $title = 'Giới thiệu';
        $description = '
ALBE tiền thân là một trung tâm dịch vụ kế toán “TRUNG TÂM TƯ VẤN THUẾ - KẾ TOÁN ALBE” từ tháng 11/2007. Đến ngày  3/10/2011 thành lập “CÔNG TY CỔ PHẦN DỊCH VỤ ĐÀO TẠO CHUYÊN NGHIỆP ALBE“  và sau đó đổi thành “ CÔNG TY TNHH DỊCH VỤ CHUYÊN NGHIỆP ALBE.';
        SEOTools::setTitle($title, appendDefault: false);
        SEOTools::setDescription($description);

        return view('front.pages.introduce');
    }
}
