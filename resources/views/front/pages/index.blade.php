@extends('front.layout.page-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Dịch vụ Kế toán và Tư vấn Thuế chuyên nghiệp')
@section('meta_tags')
    {!! SEO::generate() !!}
@endsection
@section('content')

    {{-- Dữ liệu nên được truyền từ Controller để tối ưu nhất --}}
    @php
        // Giả sử hàm latest_posts() lấy 10 bài viết mới nhất
        $posts = latest_posts(0, 10);
        $postSlides = $posts->chunk(2);

        $services = [
            [
                'title' => 'Kế toán thuê trọn gói',
                'description' => 'Dịch vụ kế toán thuế trọn gói, tối ưu nghĩa vụ thuế.',
            ],
            ['title' => 'Kế toán tổng hợp', 'description' => 'Thiết lập hệ thống sổ sách và báo cáo đầy đủ.'],
            ['title' => 'Hướng dẫn làm nghề', 'description' => 'Kèm cặp 1-1 theo case thực tế doanh nghiệp.'],
            ['title' => 'Rà soát rủi ro thuế', 'description' => 'Soát xét, tư vấn trước – trong – sau quyết toán.'],
        ];

        $faqs = [
            [
                'question' => 'ALBE có tư vấn về tối ưu thuế cho doanh nghiệp không?',
                'answer' =>
                    'Có. Chúng tôi cung cấp gói tư vấn định kỳ/ theo dự án, đánh giá rủi ro thuế và đưa ra lộ trình tối ưu.',
            ],
            [
                'question' => 'ALBE có hỗ trợ kê khai thuế theo quý và theo năm không?',
                'answer' => 'Có, tuỳ theo nhu cầu và mô hình doanh nghiệp.',
            ],
            [
                'question' => 'Các ngành nào cần báo giá dịch vụ tại ALBE?',
                'answer' => 'Mọi ngành nghề: Thương mại, dịch vụ, sản xuất, xây dựng, công nghệ, giáo dục,...',
            ],
            [
                'question' => 'ALBE có hỗ trợ doanh nghiệp nhỏ và startup không?',
                'answer' => 'Có. Chúng tôi có các gói chi phí hợp lý phù hợp cho giai đoạn đầu.',
            ],
            [
                'question' => 'ALBE cung cấp những dịch vụ kế toán và thuế nào?',
                'answer' =>
                    'Kế toán trọn gói, kế toán tổng hợp, soát xét sổ sách, tư vấn thuế, quyết toán thuế, đào tạo nhân sự kế toán,...',
            ],
        ];
    @endphp

    {{-- Section 1: Top Banner Slider --}}
    @php
        // Lấy slide và sắp xếp theo ordering tăng dần
        $slides = collect(get_slides())->sortBy('ordering')->values();
        $slideCount = $slides->count();
    @endphp

    @if ($slideCount > 0)
        <div x-data="{
            activeSlide: 0,
            slides: {{ $slideCount }},
            timer: null,
            next() {
                if (this.slides > 1) this.activeSlide = (this.activeSlide + 1) % this.slides;
            },
            prev() {
                if (this.slides > 1) this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides;
            },
        }" x-init="if (slides > 1) timer = setInterval(() => next(), 2500)" class="max-w-full mx-auto relative group">
            <div class="relative overflow-hidden rounded-lg shadow-xl h-auto bg-white">
                <div class="flex transition-transform duration-500 ease-in-out w-full"
                    :style="`transform: translateX(-${activeSlide * 100}%);`">
                    @foreach ($slides as $slide)
                        <a href="{{ $slide->link ?: '#' }}" class="min-w-full flex items-center justify-center bg-white"
                            rel="noopener noreferrer">
                            <img src="/images/slides/{{ $slide->image }}" class="w-full h-full object-contain block"
                                alt="{{ $slide->heading ?? 'Slide image' }}">
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Nút chuyển slide + chấm chỉ hiển thị khi có hơn 1 slide --}}
            <template x-if="slides > 1">
                <div>
                    <button @click="prev(); clearInterval(timer)"
                        class="absolute top-1/2 left-4 -translate-y-1/2 bg-white/30 hover:bg-white/50 rounded-full p-2.5 transition-colors z-10"
                        aria-label="Previous Slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <button @click="next(); clearInterval(timer)"
                        class="absolute top-1/2 right-4 -translate-y-1/2 bg-white/30 hover:bg-white/50 rounded-full p-2.5 transition-colors z-10"
                        aria-label="Next Slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    {{-- Chấm hiển thị vị trí --}}
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                        <template x-for="i in slides" :key="i">
                            <button @click="activeSlide = i - 1; clearInterval(timer)" class="w-3 h-1 transition-colors"
                                :class="activeSlide === i - 1 ? 'bg-[#43B14B]' : 'bg-white'"></button>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    @endif



    <div class="max-w-7xl mx-auto px-4 py-10">
        {{-- Section 2: Main Content (Posts & Sidebars) --}}

        <section class="flex flex-col lg:flex-row gap-6 mt-10">
            {{-- Left Sidebar --}}
            <aside class="w-full lg:w-2/12 lg:flex-shrink-0 flex justify-center">
                <div class="w-full flex flex-col items-center gap-y-2 lg:max-w-[180px]">
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/duongdaynong1.jpg"
                            alt="Đường dây nóng Tổng Cục Thuế"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/20151210-Logo+Tap+chi+Thue-nho.jpg"
                            alt="Tạp chí Thuế Việt Nam"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/hoituvanthue.jpg"
                            alt="Hội tư vấn thuế Việt Nam"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/phobientuyentruyen.gif"
                            alt="Phổ biến tuyên truyền chính sách thuế"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/congchinhphu.jpg"
                            alt="Cổng thông tin điện tử Chính Phủ"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/botaichinh.jpg"
                            alt="Cổng thông tin Bộ Tài Chính"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/CongTTDTDanhChoNhaCungCapNuocNgoai.jpg"
                            alt="Cổng thông tin cho nhà cung cấp nước ngoài"></a>
                    <a href="https://gdt.gov.vn/wps/portal/home/hotline" target="_blank" rel="noopener noreferrer"><img
                            src="https://albe.com.vn/datafiles/48682/upload/files/Widget%20Thue%20VietNam/bo-phap-dien.png"
                            alt="Bộ pháp điển"></a>
                </div>
            </aside>

            {{-- Main Post Slider --}}
            <main class="w-full lg:w-7/12">
                @if ($posts->isNotEmpty())
                    <div x-data="{
                        currentPostSlide: 0,
                        totalPostSlides: {{ $postSlides->count() }},
                        timer: null,
                        next() {
                            if (this.totalPostSlides > 1) {
                                this.currentPostSlide = (this.currentPostSlide + 1) % this.totalPostSlides;
                            }
                        },
                        prev() {
                            if (this.totalPostSlides > 1) {
                                this.currentPostSlide = (this.currentPostSlide - 1 + this.totalPostSlides) % this.totalPostSlides;
                            }
                        },
                        goTo(index) {
                            if (index >= 0 && index < this.totalPostSlides) {
                                this.currentPostSlide = index;
                            }
                        }
                    }" x-init="if (totalPostSlides > 1) timer = setInterval(() => next(), 3000)" class="relative h-full">
                        <!-- Slider Wrapper -->
                        <div class="overflow-hidden h-full ">
                            <div class="flex transition-transform duration-700 ease-in-out h-full"
                                :style="`transform: translateX(-${currentPostSlide * 100}%);`">
                                @foreach ($postSlides as $chunk)
                                    <div class="min-w-full grid grid-cols-1 sm:grid-cols-2 gap-4 px-2 py-2">
                                        @foreach ($chunk as $post)
                                            <article
                                                class="bg-white border rounded-2xl flex flex-col hover:shadow-lg transition">
                                                <a href="{{ route('read_post', $post->slug) }}">
                                                    <img src="/images/posts/{{ $post->featured_image }}"
                                                        alt="{{ $post->title }}"
                                                        class="h-40 w-full object-cover rounded-t-2xl">
                                                </a>
                                                <div class="p-4 space-y-2 flex-1 flex flex-col">
                                                    @if ($post->post_category)
                                                        <a href="{{ route('category_posts', $post->post_category->slug) }}"
                                                            class="text-xs text-green-700 font-semibold uppercase hover:underline">
                                                            {{ $post->post_category->name }}
                                                        </a>
                                                    @endif
                                                    <h3 class="text-lg font-bold flex-grow">
                                                        <a href="{{ route('read_post', $post->slug) }}"
                                                            class="hover:text-green-700 line-clamp-2">{{ $post->title }}</a>
                                                    </h3>
                                                    <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed py-2">
                                                        {!! Str::limit(strip_tags($post->excerpt ?? $post->content), 150) !!}
                                                    </p>
                                                    <a href="{{ route('read_post', $post->slug) }}"
                                                        class="inline-flex items-center gap-1 text-green-700 font-semibold hover:underline text-sm mt-auto">
                                                        Xem thêm →
                                                    </a>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Nút điều hướng -->
                        <button @click="prev(); clearInterval(timer)"
                            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/70 hover:bg-white shadow-md p-2 rounded-full hover:scale-110 transition -translate-x-1/2"
                            aria-label="Previous Post Set" x-show="totalPostSlides > 1">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                            </svg>
                        </button>

                        <button @click="next(); clearInterval(timer)"
                            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/70 hover:bg-white shadow-md p-2 rounded-full hover:scale-110 transition translate-x-1/2"
                            aria-label="Next Post Set" x-show="totalPostSlides > 1">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.59 16.59 10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                            </svg>
                        </button>

                        <!-- Dots chỉ báo -->
                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2 z-10"
                            x-show="totalPostSlides > 1">
                            <template x-for="i in totalPostSlides" :key="i">
                                <button @click="goTo(i - 1); clearInterval(timer)"
                                    class="w-3 h-3 rounded-full transition-all"
                                    :class="currentPostSlide === i - 1 ? 'bg-[#43B14B] scale-110' :
                                        'bg-gray-300 hover:bg-gray-400'"></button>
                            </template>
                        </div>
                    </div>
                @else
                    <div class="min-w-full p-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                        <p>Chưa có bài viết nào.</p>
                    </div>
                @endif
            </main>


            <aside class="w-full lg:w-3/12 flex flex-col">
                <h2 class="bg-[#43b14b] text-white text-center text-lg font-semibold py-4 rounded-t-xl uppercase">Tin mới
                    nhất
                </h2>
                @if ($posts->isNotEmpty())
                    <ul class="divide-y border rounded-b-xl flex-grow">
                        @foreach ($posts->take(5) as $latestPost)
                            <li><a href="{{ route('read_post', $latestPost->slug) }}"
                                    class="block p-4 hover:bg-gray-50 text-sm font-medium truncate uppercase"
                                    title="{{ $latestPost->title }}">{{ $latestPost->title }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-4 text-center text-gray-500 border rounded-b-xl flex-grow">Không có tin mới.</p>
                @endif
            </aside>
        </section>

        {{-- Section 3: Video & Highlights --}}
        <section class="mt-10 grid lg:grid-cols-3 gap-6">
            {{-- Cột bên trái (Video) --}}
            <div class="lg:col-span-2 bg-white border rounded-2xl shadow-sm overflow-hidden">
                <div class="relative group">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=2069&auto=format&fit=crop"
                        class="w-full h-72 object-cover" alt="Nhóm chuyên gia đang họp bàn về công việc">
                    <button
                        class="absolute inset-0 m-auto w-16 h-16 rounded-full bg-white/90 text-[#43b14b] shadow-lg group-hover:scale-110 transition-transform flex items-center justify-center"
                        aria-label="Play Video">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 ml-1" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <h2 class="font-semibold text-lg">Lộ trình học rõ ràng, giảng viên tận tâm</h2>
                    <p class="text-slate-600 text-sm mt-1">Giảng viên kinh nghiệm, bài tập thực tế, hỗ trợ 1-1 trong suốt
                        quá trình học.</p>
                </div>
            </div>

            {{-- Cột bên phải (Điểm nổi bật) -- ĐÃ SỬA --}}
            <div class="bg-white border rounded-2xl shadow-sm p-5 flex flex-col">
                <h2 class="font-semibold text-lg text-gray-800">Điểm nổi bật</h2>
                <ul class="mt-3 space-y-3">
                    <li class="flex gap-3"><span class="mt-1.5 h-2 w-2 rounded-full bg-[#43b14b]"></span><span>Giáo trình
                            thực chiến, cập nhật theo luật mới</span></li>
                    <li class="flex gap-3"><span class="mt-1.5 h-2 w-2 rounded-full bg-[#43b14b]"></span><span>Hỗ trợ việc
                            làm & thực tập</span></li>
                    <li class="flex gap-3"><span class="mt-1.5 h-2 w-2 rounded-full bg-[#43b14b]"></span><span>Cam kết đầu
                            ra – Học lại miễn phí</span></li>
                </ul>
                {{-- Đẩy nút này xuống dưới cùng --}}
                <a href="#"
                    class="mt-auto inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-[#43b14b] text-white font-semibold hover:bg-opacity-90 transition">
                    Tư vấn khoá học
                </a>
            </div>
        </section>

        {{-- Section 4: Services --}}
        <section class="mt-12">
            <div class="relative rounded-3xl overflow-hidden">
                <img src="https://images.unsplash.com/photo-1473186505569-9c61870c11f9?q=80&w=1974&auto=format&fit=crop"
                    class="absolute inset-0 w-full h-full object-cover" alt="Nền trừu tượng màu xanh lá cây" />
                <div class="relative bg-black/50">
                    <div class="max-w-7xl mx-auto px-4 py-12">
                        <div class="flex flex-wrap gap-4 justify-between items-center">
                            <h2 class="text-2xl md:text-3xl font-bold text-white uppercase">Dịch vụ ALBE</h2>
                            <a href="#"
                                class="text-sm md:text-base text-white border-b-2 border-white hover:text-[#4AB14B] hover:border-[#4AB14B] transition-colors duration-300">Xem
                                tất cả</a>
                        </div>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-4 mt-6">
                            @foreach ($services as $service)
                                <div class="bg-white/95 p-5 rounded-2xl shadow-sm">
                                    <h3 class="font-semibold text-gray-800">{{ $service['title'] }}</h3>
                                    <p class="text-sm text-slate-600 mt-2">{{ $service['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 5: FAQ --}}
        <section class="mt-12">
            <h2 class="text-center text-2xl md:text-3xl font-bold">Câu hỏi thường gặp</h2>
            <div class="mt-6 max-w-3xl mx-auto space-y-3">
                @foreach ($faqs as $faq)
                    <details
                        class="group bg-white border border-slate-200 rounded-xl p-4 open:shadow-card transition-shadow">
                        <summary class="flex items-center justify-between cursor-pointer list-none">
                            <span class="font-semibold">{{ $faq['question'] }}</span>
                            <svg class="w-5 h-5 transition-transform duration-300 group-open:rotate-180"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <p class="mt-3 text-slate-600">{{ $faq['answer'] }}</p>
                    </details>
                @endforeach
            </div>
        </section>
    </div>
@endsection
