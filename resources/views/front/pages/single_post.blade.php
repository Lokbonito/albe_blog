@extends('front.layout.page-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')
@section('meta_tags')
    {!! SEO::generate() !!}
@endsection
@section('content')

    <section class="relative flex items-center justify-center text-white">

        <img src="{{ asset('/images/slides/SLD_20251016171632.jpg') }}" alt="Banner nền trang danh mục"
            class="w-full h-auto object-cover">

        {{-- Lớp phủ tối màu để làm nổi bật chữ --}}
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        {{-- Nội dung banner --}}
        <div class="absolute text-center px-4">
            {{-- Tên thể loại (sẽ được truyền từ controller) --}}
            <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-wider">
                {{ $post->post_category->name }}
            </h1>

            {{-- Breadcrumb --}}
            <div class="mt-4 text-sm">
                {{-- Sử dụng route() để liên kết an toàn hơn là dùng "/" --}}
                <a href="{{ route('home') }}" class="hover:underline">Trang chủ</a>
                <span class="mx-2">/</span>
                <span>{{ $post->post_category->name }}</span>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-4 py-8 flex flex-col lg:flex-row gap-8">
        <!-- LEFT CONTENT -->
        <article class="lg:w-2/3">
            <h2 class="text-2xl font-bold mb-2">{{ $post->title }}</h2>
            <p class="text-gray-500 text-sm mb-6">{{ date_formatter($post->created_at) }} • 9 lượt
                xem</p>
            <div class="content-area">
                {!! $post->content !!}
            </div>

            <div
                class="mt-6 mb-6 post-navigation bg-gray-50 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-6">

                    @if ($prevPost)
                        <div class="w-full md:w-1/2 text-left">
                            <h6 class="text-sm uppercase text-gray-500 tracking-wide mb-1">« Previous</h6>
                            <a href="{{ route('read_post', $prevPost->slug) }}"
                                class="relative text-emerald-600 font-medium text-base hover:text-emerald-800 transition-colors duration-300
                      after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:w-0 after:h-0.5 after:bg-emerald-600
                      hover:after:w-full after:transition-all after:duration-300">
                                {{ $prevPost->title }}
                            </a>
                        </div>
                    @endif

                    @if ($nextPost)
                        <div class="w-full md:w-1/2 text-right">
                            <h6 class="text-sm uppercase text-gray-500 tracking-wide mb-1">Next »</h6>
                            <a href="{{ route('read_post', $nextPost->slug) }}"
                                class="relative text-emerald-600 font-medium text-base hover:text-emerald-800 transition-colors duration-300
                      after:content-[''] after:absolute after:right-0 after:-bottom-0.5 after:w-0 after:h-0.5 after:bg-emerald-600
                      hover:after:w-full after:transition-all after:duration-300">
                                {{ $nextPost->title }}
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </article>
        <!-- SIDEBAR -->
        <aside class="lg:w-1/3">
            <div class="bg-gray-100 rounded-lg shadow p-4 mb-6">
                <h3 class="font-bold text-lg mb-2">Danh mục tin tức</h3>
                <ul class="space-y-2 text-green-700">
                    <li><a href="#">Đào tạo</a></li>
                    <li><a href="#">Kế toán</a></li>
                    <li><a href="#">Thuế thu nhập doanh nghiệp</a></li>
                    <li><a href="#">Lao động - Bảo hiểm xã hội</a></li>
                </ul>
            </div>
        </aside>
    </main>

    @if ($relatedPosts && $relatedPosts->count() > 0)
        <section class="container mx-auto px-4 py-8">
            <h3 class="text-2xl font-bold mb-6 text-slate-800">Bài viết liên quan</h3>

            <div class="relative">

                <main class="overflow-hidden rounded-lg">
                    <div id="sliderTrack" class="flex transition-transform duration-500 ease-in-out">

                        {{-- 
                        Sử dụng chunk(2) để nhóm các bài viết thành từng cặp.
                        Mỗi cặp sẽ là một "slide".
                    --}}
                        @foreach ($relatedPosts->chunk(3) as $postChunk)
                            <div class="min-w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-1">

                                {{-- Lặp qua 2 bài viết trong mỗi slide --}}
                                @foreach ($postChunk as $post)
                                    <article
                                        class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col overflow-hidden group">
                                        <a href="{{ route('read_post', $post->slug) }}" class="block overflow-hidden">
                                            {{-- Giả sử bạn có một trường 'image_url' hoặc tương tự trong model Post --}}
                                            <img src="/images/posts/{{ $post->featured_image }}" alt="{{ $post->title }}"
                                                class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </a>
                                        <div class="p-5 flex flex-col flex-grow">
                                            @if ($post->post_category)
                                                <p class="text-xs text-green-700 font-semibold uppercase mb-2">
                                                    {{ $post->post_category->name }}</p>
                                            @endif
                                            <h4 class="text-lg font-bold text-slate-800 mb-2 flex-grow">
                                                <a href="{{ route('read_post', $post->slug) }}"
                                                    class="hover:text-green-700 transition-colors">
                                                    {{ Str::limit($post->title, 60) }}
                                                </a>
                                            </h4>
                                            <a href="{{ route('read_post', $post->slug) }}"
                                                class="text-green-700 font-semibold inline-flex items-center mt-3 self-start">
                                                Xem thêm
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach

                            </div>
                        @endforeach

                    </div>
                </main>

                <button id="prevBtn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 backdrop-blur-sm shadow-lg p-2 rounded-full hover:scale-110 transition-transform focus:outline-none -ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button id="nextBtn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/90 backdrop-blur-sm shadow-lg p-2 rounded-full hover:scale-110 transition-transform focus:outline-none -mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </section>
    @endif


@endsection
