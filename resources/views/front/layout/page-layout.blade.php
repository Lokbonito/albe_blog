<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    @yield('meta_tags')
    <link rel="shortcut icon" href="/front/images/Logo-_1_.ico" type="image/x-icon">
    <link rel="stylesheet" href="/front/css/output.css">
    <link rel="icon" href="/front/images/Logo-_1_.ico" type="image/x-icon">
    <link rel="stylesheet" href="/front/plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/extra-assets/ijabo/css/ijabo.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('stylesheet')

    <style>
        /* Custom tiny utilities (still pure CSS) */
        .clamp-hero {
            font-size: clamp(1.5rem, 3vw + 1rem, 3rem);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
            width: 6px
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px
        }
    </style>
</head>

<body class="antialiased text-slate-700">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="bg-[#4ab14b] text-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center py-2 text-sm">

                <div class="flex items-center space-x-2 mb-2 md:mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Trụ sở chính: Tòa B2 1902 Tecco Garden-Tứ Hiệp-Thanh Trì-Hà Nội</span>
                </div>

                @if (settings()->site_email)
                    <div class="flex items-center space-x-2 mb-2 md:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <span>{{ settings()->site_email }}</span>
                    </div>
                @endif

                <div class="flex items-center space-x-2 mb-2 md:mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Thứ 2 - thứ 7</span>
                </div>

                @if (settings()->site_phone)
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <span>{{ settings()->site_phone }}</span>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between py-2">
                <a href="/" class="flex items-center gap-3">
                    <img class="img-fluid" width="150px"
                        src="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}"
                        class="h-20" alt="{{ isset(settings()->site_title) ? settings()->site_logo : '' }}" />
                </a>
                <button id="btnMobile"
                    class="md:hidden inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50"
                    aria-label="Mở menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>Menu</span>
                </button>

                <nav id="nav"
                    class="hidden md:flex items-center gap-6 text-[#336E4C] uppercase whitespace-nowrap">
                    <a href="/"
                        class="font-medium !no-underline decoration-none border-b-0 focus:outline-none
          hover:text-[#43b14b] transition-colors duration-200 ease-in-out">
                        Trang chủ
                    </a>

                    <a class="font-medium !no-underline decoration-none border-b-0 focus:outline-none
          hover:text-[#43b14b] transition-colors duration-200 ease-in-out"
                        href="{{ route('introduce') }}">Giới
                        thiệu</a>

                    {!! services_dropdown() !!}

                    <a href="{{ route('category_posts', 'dao-tao') }}"
                        class="font-medium !no-underline decoration-none border-b-0 focus:outline-none
          hover:text-[#43b14b] transition-colors duration-200 ease-in-outwhitespace-nowrap">
                        ĐÀO TẠO
                    </a>

                    {!! knowledge_dropdown() !!}

                    <a href="{{ route('category_posts', 'tin-tuc') }}"
                        class="font-medium !no-underline decoration-none border-b-0 focus:outline-none
          hover:text-[#43b14b] transition-colors duration-200 ease-in-out">Tin
                        tức</a>
                    <a href="{{ route('category_posts', 'van-ban-phap-luat') }}"
                        class="font-medium !no-underline decoration-none border-b-0 focus:outline-none
          hover:text-[#43b14b] transition-colors duration-200 ease-in-out">Văn
                        bản
                        pháp
                        luật</a>
                    <a class="font-medium !no-underline decoration-none border-b-0 focus:outline-none
          hover:text-[#43b14b] transition-colors duration-200 ease-in-out"
                        href="{{ route('contact') }}">Liên
                        hệ</a>
                </nav>
            </div>

            {{-- Mobile drawer --}}

            <div id="drawer" class="hidden md:hidden pb-3 border-t border-slate-200">
                <div class="pt-3 grid gap-2">
                    <a href="/"
                        class="px-4 py-2 rounded-xl font-semibold tracking-wide uppercase text-slate-700 
          hover:text-white hover:bg-[#43b14b] transition-all duration-300 ease-in-out">
                        Trang chủ
                    </a>
                    <a class="px-4 py-2 rounded-xl font-semibold tracking-wide uppercase text-slate-700 
          hover:text-white hover:bg-[#43b14b] transition-all duration-300 ease-in-out"
                        href="{{ route('introduce') }}">Giới
                        thiệu</a>
                    {!! services_dropdown_mobile() !!}
                    <a class="px-3 py-2 rounded-lg hover:bg-slate-50 uppercase"
                        href="{{ route('category_posts', 'dao-tao') }}">Đào tạo</a>
                    {!! knowledge_dropdown_mobile() !!}

                    <a class="px-4 py-2 rounded-xl font-semibold tracking-wide uppercase text-slate-700 
          hover:text-white hover:bg-[#43b14b] transition-all duration-300 ease-in-out"
                        href="{{ route('category_posts', 'tin-tuc') }}">Tin tức</a>
                    <a class="px-4 py-2 rounded-xl font-semibold tracking-wide uppercase text-slate-700 
          hover:text-white hover:bg-[#43b14b] transition-all duration-300 ease-in-out"
                        href="{{ route('category_posts', 'van-ban-phap-luat') }}">Văn bản pháp luật</a>
                    <a class="px-4 py-2 rounded-xl font-semibold tracking-wide uppercase text-slate-700 
          hover:text-white hover:bg-[#43b14b] transition-all duration-300 ease-in-out"
                        href="{{ route('contact') }}">Liên hệ</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>


    <footer class="mt-12 bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3">
                        <a href="/" class="flex items-center gap-3">
                            <img class="img-fluid" width="200px"
                                src="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}"
                                class="h-20"
                                alt="{{ isset(settings()->site_title) ? settings()->site_logo : '' }}" />
                        </a>
                    </div>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>Tòa B2 1902 Tecco Garden Tứ Hiệp Thanh Trì, Hà
                            Nội</li>
                        <li>Điện thoại: {{ settings()->site_phone }}</li>
                        <li>Email: <a class="underline"
                                href="mailto:{{ settings()->site_email }}">{{ settings()->site_email }}</a>
                        </li>
                    </ul>
                    <div class="mt-4 flex gap-3">
                        @if (site_social_links()->facebook_url)
                            <a class="p-2 rounded-lg bg-white/10 hover:bg-white/20"
                                href="{{ site_social_links()->facebook_url }}" aria-label="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22 12a10 10 0 10-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.16 1.8.16v2h-1c-1 0-1.3.63-1.3 1.28V12h2.3l-.37 3h-1.93v7A10 10 0 0022 12z" />
                                </svg>
                            </a>
                        @endif

                        @if (site_social_links()->youtube_url)
                            <a class="p-2 rounded-lg bg-white/10 hover:bg-white/20"
                                href="{{ site_social_links()->youtube_url }}" aria-label="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.5 6.2a3 3 0 00-2.1-2.1C19.7 3.5 12 3.5 12 3.5s-7.7 0-9.4.6A3 3 0 00.5 6.2 31.6 31.6 0 000 12c0 5.8.5 5.8 2.6 6.6 1.7.6 9.4.6 9.4.6s7.7 0 9.4-.6a3 3 0 002.1-2.1c.6-1.7.6-5.5.6-5.5s0-3.8-.6-5.5zM9.75 15.02V8.98L15.5 12l-5.75 3.02z" />
                                </svg>
                            </a>
                        @endif

                        @if (site_social_links()->instagram_url)
                            <a class="p-2 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center"
                                href="{{ site_social_links()->instagram_url }}" aria-label="Instagram">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" />
                                    <path
                                        d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" />
                                </svg>
                            </a>
                        @endif

                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-white">Thông tin thêm</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a class="!no-underline" href="/">Trang
                                chủ</a></li>
                        <li><a class="!no-underline" href="{{ route('introduce') }}">Giới
                                thiệu</a></li>
                        <li><a class="!no-underline" href="{{ route('category_posts', 'tin-tuc') }}">Tin
                                tức</a></li>
                        <li><a class="!no-underline" href="{{ route('contact') }}">Liên
                                hệ</a></li>
                    </ul>
                </div>
                <div>
                    {!! footer_services_link() !!}
                </div>
                <div>
                    <h4 class="font-semibold text-white">Fanpage</h4>
                    <div class="mt-4 rounded-xl bg-white/5 p-4 text-sm"></div>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-white/10 text-sm text-center text-slate-400">Bản
                quyền © <span id="year"></span> ALBE. Nội dung thuộc về Công
                ty TNHH Dịch vụ Chuyên nghiệp ALBE.</div>
        </div>
    </footer>
    <button id="backToTop"
        class="fixed bottom-6 right-6 hidden items-center justify-center w-10 h-10 rounded-full bg-[#059669] text-white shadow hover:bg-[#047857]"
        style="box-shadow: 0 10px 30px -12px rgba(0,0,0,.15)" aria-label="Về đầu trang">↑</button>
    @stack('script')
    <script src="/front/js/script.js" defer></script>
    <script src="/front/plugins/jQuery/jquery.min.js"></script>
    <script src="/extra-assets/ijabo/js/ijabo.min.js"></script>
    <script src="/front/plugins/bootstrap/bootstrap.min.js"></script>
</body>

</html>
