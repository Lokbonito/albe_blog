@extends('front.layout.page-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Document title')
@section('meta_tags')
    {!! SEO::generate() !!}
@endsection
@section('content')

    {{-- Bắt đầu: Banner trang danh mục --}}
    <section class="relative flex items-center justify-center text-white">

        <img src="{{ asset('/images/slides/SLD_20251016171632.jpg') }}" alt="Banner nền trang danh mục"
            class="w-full h-auto object-cover">

        {{-- Lớp phủ tối màu để làm nổi bật chữ --}}
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        {{-- Nội dung banner --}}
        <div class="absolute text-center px-4">
            {{-- Tên thể loại (sẽ được truyền từ controller) --}}
            <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-wider">
                {{ $pageTitle }}
            </h1>

            {{-- Breadcrumb --}}
            <div class="mt-4 text-sm">
                {{-- Sử dụng route() để liên kết an toàn hơn là dùng "/" --}}
                <a href="{{ route('home') }}" class="hover:underline">Trang chủ</a>
                <span class="mx-2">/</span>
                <span>{{ $pageTitle }}</span>
            </div>
        </div>
    </section>
    {{-- Kết thúc: Banner trang danh mục --}}

    {{-- Phần thân trang --}}
    <div class="bg-slate-50 py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Lưới chứa các bài viết --}}
            @if ($posts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    {{-- BẮT ĐẦU: Lặp 6 bài viết mẫu --}}
                    {{-- Thay thế vòng lặp @for này bằng @foreach ($posts as $post) của bạn --}}

                    @foreach ($posts as $post)
                        <article
                            class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col transition-transform duration-300 hover:-translate-y-1 group">
                            {{-- Phần hình ảnh --}}
                            <div class="relative">
                                <a href="#">
                                    <img class="w-full h-56 object-cover" src="/images/posts/{{ $post->featured_image }}"
                                        alt="">
                                </a>
                                {{-- Lớp phủ chứa thông tin meta --}}
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-40 p-4 flex flex-col text-white text-xs font-semibold">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ date_formatter($post->created_at) }}</span>
                                        </div>
                                        {{-- <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>{{ rand(100, 300) }} Lượt xem</span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            {{-- Phần nội dung --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <h2 class="text-lg font-bold text-gray-800 flex-grow">
                                    <a href="{{ route('read_post', $post->slug) }}"
                                        class="group-hover:text-green-600 transition-colors line-clamp-3 no-underline">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed py-2">
                                    {!! Str::limit(strip_tags($post->excerpt ?? $post->content), 150) !!}</p>
                                <a href="{{ route('read_post', $post->slug) }}"
                                    class="mt-4 inline-block text-green-600 font-semibold hover:underline self-start">
                                    Xem thêm
                                </a>
                            </div>
                        </article>
                    @endforeach
                    {{-- KẾT THÚC: Vòng lặp --}}
                </div>
            @else
                <p><span class="text-danger">No post found in this category</span></p>
            @endif

            {{-- Phân trang --}}
            <nav class="mt-12 flex justify-center" aria-label="Pagination">
                {{ $posts->appends(request()->input())->links('custom_pagination') }}
            </nav>

        </div>
    </div>
@endsection
