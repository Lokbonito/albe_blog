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
                {!! SEO::getTitle() !!}
            </h1>

            {{-- Breadcrumb --}}
            <div class="mt-4 text-sm">
                {{-- Sử dụng route() để liên kết an toàn hơn là dùng "/" --}}
                <a href="{{ route('home') }}" class="hover:underline">Trang chủ</a>
                <span class="mx-2">/</span>
                <span>{!! SEO::getTitle() !!}</span>
            </div>
        </div>
    </section>

    <div class="max-w-6xl px-6 pt-6 lg:pt-10 pb-12 sm:px-8 lg:px-10 mx-auto">
        <div class="max-w-6xl mx-auto">
            <!-- Content -->
            <div class="space-y-5 md:space-y-8">
                <div class="space-y-3">
                    <h2 class="text-2xl font-bold md:text-3xl">GIỚI THIỆU</h2>

                    <figure class="flex flex-col items-center">
                        <img class="w-1/2 object-cover rounded-xl" src="/images/introduce_page/unnamed.png"
                            alt="Blog Image">
                    </figure>
                    <p class="text-base font-bold text-gray-800">
                        ALBE tiền thân là một trung tâm dịch vụ kế toán “TRUNG TÂM TƯ VẤN THUẾ - KẾ TOÁN ALBE” từ tháng
                        11/2007.
                        Đến ngày 3/10/2011 thành lập “CÔNG TY CỔ PHẦN DỊCH VỤ ĐÀO TẠO CHUYÊN NGHIỆP ALBE“ và sau đó đổi
                        thành
                        “CÔNG TY TNHH DỊCH VỤ CHUYÊN NGHIỆP ALBE”.
                    </p>

                    <ul class="list-disc list-outside space-y-5 ps-5 text-base text-gray-800">
                        <li class="ps-2">
                            Trụ sở chính : Tứ Hiệp-Thanh Trì-Hà Nội
                        </li>
                        <li class="ps-2">
                            Văn phòng giao dịch 1: B2412 Tứ Hiệp Plaza – Thanh Trì Hà Nội
                        </li>
                        <li class="ps-2">
                            Văn phòng giao dịch 2. S211 0301 Vinhomes Ocean Park – Gia Lâm Hà Nội
                        </li>
                        <li class="ps-2">
                            Hotline : 0822 88 4646 – 0899 48 2626
                        </li>
                    </ul>

                    <p class="text-base text-gray-800">
                        Thương hiệu ALBE đã được bảo hộ độc quyền tại cục Sở hữu Trí Tuệ
                    </p>

                    <p class="text-base font-bold text-gray-800">
                        Ý nghĩa thương hiệu ALBE: Accountant Leading Business Effective
                    </p>

                    <ul class="list-disc list-outside space-y-5 ps-5 text-base text-gray-800">
                        <li class="ps-2">
                            A. Accountant ( Kế toán)
                        </li>
                        <li class="ps-2">
                            l. leading ( Dẫn dắt, đồng hành)
                        </li>
                        <li class="ps-2">
                            B. Business ( Kinh doanh)
                        </li>
                        <li class="ps-2">
                            E. Effective ( Hiệu quả)
                        </li>
                    </ul>

                    <p class="text-base text-gray-800">
                        Với 17 năm hình thành và phát triển ALBE đã, đang và sẽ luôn tận tuỵ làm việc với mong muốn luôn tạo
                        giá trị cho Doanh nghiệp, cho cộng đồng nhân sự làm nghề kế toán, tư vấn thuế, luật. ALBE thông qua
                        những giá trị đó để có thể phụng sự cho Doanh nghiệp phát triển, góp phần làm cho đất nước giàu
                        mạnh.
                    </p>

                    <p class="text-base font-bold text-gray-800">
                        LĨNH VỰC TƯ VẤN DỊCH VỤ THUẾ - KẾ TOÁN
                    </p>

                    <ul class="list-disc list-outside space-y-5 ps-5 text-base text-gray-800">
                        <li class="ps-2">
                            ALBE đồng hành cùng đội ngũ nhân sự nội bộ để hoàn thành tốt nhiệm vụ
                        </li>
                        <li class="ps-2">
                            ALBE thực hiện tư vấn, cảnh báo nhằm mục tiêu tối ưu thuế và giảm thiểu rủi ro về thuế cho Doanh
                            nghiệp từ việc hiểu đúng và làm đúng các quy định của pháp luật về thuế và kế toán cũng như các
                            lĩnh vực khác.
                        </li>
                        <li class="ps-2">
                            ALBE luôn đồng hành cùng Doanh nghiệp để phát triển bền vững và lớn mạnh nhằm tạo lợi nhuận cho
                            Doanh nghiệp, tạo giá trị cho xã hội và góp phần vào việc kiến tạo và xây dựng đất nước giàu
                            mạnh.
                        </li>
                        <li class="ps-2">
                            ALBE với nguyên tắc làm việc tuân thủ pháp luật hiện hành và đồng hành để tháo gỡ những vướng
                            mắc trong qua trình kinh doanh của Doanh nghiệp.Trách nhiệm và sự tận tuỵ với công việc là điều
                            mà chúng tôi thực hiện với mỗi khách hàng.
                        </li>
                    </ul>

                    <p class="text-base font-bold text-gray-800">
                        LĨNH VỰC ĐÀO TẠO LUẬT - THUẾ - KẾ TOÁN
                    </p>

                    <ul class="list-disc list-outside space-y-5 ps-5 text-base text-gray-800">
                        <li class="ps-2">
                            Đào tạo đội ngũ nhân sự hiểu đúng, nhận thức đúng pháp luật để làm đúng và phù hợp các quy định
                            của pháp luật hiện hành từ đó giảm thiểu rủi ro về thuế và kế toán cho Doanh nghiệp.
                        </li>
                        <li class="ps-2">
                            Truyền cảm hứng cho đội ngũ làm kế toán, tài chính, kiểm toán , tư vấn luật .. có thể hạnh phúc
                            làm việc từ nghề, tạo giá trị, phụng sự doanh nghiệp và xã hội, kiến tạo đất nước giàu mạnh.
                        </li>
                    </ul>

                </div>
                <!-- End Content -->
            </div>
        </div>
        <!-- End Blog Article -->
    </div>

@endsection
