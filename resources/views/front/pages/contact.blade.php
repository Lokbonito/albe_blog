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

    <div class="container mx-auto px-4 sm:px-6 lg:px-12 py-8 sm:py-12">

        <header class="flex flex-col sm:flex-row justify-between sm:items-center mb-12">
            <div class="mb-6 sm:mb-0">
                <p class="mt-3 font-bold text-gray-600 max-w-lg">
                    Thông tin liên hệ
                </p>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                    CÔNG TY TNHH DỊCH VỤ CHUYÊN NGHIỆP ALBE
                </h1>

                <div class="w-16 h-1 bg-green-600 mt-2 rounded"></div>
            </div>
        </header>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="flex flex-col items-center p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M5.7 15C4.03377 15.6353 3 16.5205 3 17.4997C3 19.4329 7.02944 21 12 21C16.9706 21 21 19.4329 21 17.4997C21 16.5205 19.9662 15.6353 18.3 15M12 9H12.01M18 9C18 13.0637 13.5 15 12 18C10.5 15 6 13.0637 6 9C6 5.68629 8.68629 3 12 3C15.3137 3 18 5.68629 18 9ZM13 9C13 9.55228 12.5523 10 12 10C11.4477 10 11 9.55228 11 9C11 8.44772 11.4477 8 12 8C12.5523 8 13 8.44772 13 9Z" />
                    </svg>
                </div>
                <span class="text-center font-semibold text-gray-700 mt-2">
                    Tòa B2 1902 Tecco Garden-Tứ Hiệp-Thanh Trì-Hà Nội
                </span>
            </div>

            <div class="flex flex-col items-center p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <span class="text-center font-semibold text-gray-700 mt-2">cskh.albe@gmail.com</span>
            </div>

            <div class="flex flex-col items-center p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-center font-semibold text-gray-700 mt-2">Thứ 2 - Thứ 7</span>
            </div>
            <div class="flex flex-col items-center p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M14.05 6C15.0268 6.19057 15.9244 6.66826 16.6281 7.37194C17.3318 8.07561 17.8095 8.97326 18 9.95M14.05 2C16.0793 2.22544 17.9716 3.13417 19.4163 4.57701C20.8609 6.01984 21.7721 7.91101 22 9.94M18.5 21C9.93959 21 3 14.0604 3 5.5C3 5.11378 3.01413 4.73086 3.04189 4.35173C3.07375 3.91662 3.08968 3.69907 3.2037 3.50103C3.29814 3.33701 3.4655 3.18146 3.63598 3.09925C3.84181 3 4.08188 3 4.56201 3H7.37932C7.78308 3 7.98496 3 8.15802 3.06645C8.31089 3.12515 8.44701 3.22049 8.55442 3.3441C8.67601 3.48403 8.745 3.67376 8.88299 4.05321L10.0491 7.26005C10.2096 7.70153 10.2899 7.92227 10.2763 8.1317C10.2643 8.31637 10.2012 8.49408 10.0942 8.64506C9.97286 8.81628 9.77145 8.93713 9.36863 9.17882L8 10C9.2019 12.6489 11.3501 14.7999 14 16L14.8212 14.6314C15.0629 14.2285 15.1837 14.0271 15.3549 13.9058C15.5059 13.7988 15.6836 13.7357 15.8683 13.7237C16.0777 13.7101 16.2985 13.7904 16.74 13.9509L19.9468 15.117C20.3262 15.255 20.516 15.324 20.6559 15.4456C20.7795 15.553 20.8749 15.6891 20.9335 15.842C21 16.015 21 16.2169 21 16.6207V19.438C21 19.9181 21 20.1582 20.9007 20.364C20.8185 20.5345 20.663 20.7019 20.499 20.7963C20.3009 20.9103 20.0834 20.9262 19.6483 20.9581C19.2691 20.9859 18.8862 21 18.5 21Z" />
                    </svg>
                </div>
                <span class="text-center font-semibold text-gray-700 mt-2">0822 88 4646 - 0899 46 2626</span>
            </div>
        </div>

        <form action="{{ route('send_email') }}" method="POST" class="bg-gray-50 p-8 rounded-2xl border border-gray-200">
            @csrf
            <x-form-alerts></x-form-alerts>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="form-group">
                    <label for="first-name" class="block text-sm font-semibold text-gray-800 mb-2">Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Họ và tên"
                        class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-green focus:border-transparent transition"
                        value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">Email<span
                            class="text-red-500">*</span></label>
                    <input type="text" name="email" id="email" placeholder="Email"
                        class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-green focus:border-transparent transition"
                        value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phoneNumber" class="block text-sm font-semibold text-gray-800 mb-2">Số điện thoại
                        <span class="text-red-500">*</span></label>
                    <input type="tel" name="phoneNumber" id="phoneNumber" placeholder="Số điện thoại"
                        class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-green focus:border-transparent transition"
                        value="{{ old('phoneNumber') }}">
                    @error('phoneNumber')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="block text-sm font-semibold text-gray-800 mb-2">Địa chỉ <span
                            class="text-red-500">*</span></label>
                    <input type="address" name="address" id="address" placeholder="Địa chỉ"
                        class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-green focus:border-transparent transition"
                        value="{{ old('address') }}">
                    @error('address')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2 form-group">
                    <label for="message" class="block text-sm font-semibold text-gray-800 mb-2">Tin nhắn <span
                            class="text-red-500">*</span></label>
                    <textarea name="message" id="message" placeholder="Tin nhắn" rows="6"
                        class="block w-full px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-custom-green focus:border-transparent transition">{{ old('message') }}</textarea>
                    @error('message')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <button type="submit"
                        class="block mx-auto w-1/2 bg-[#43ba32] text-white font-bold py-4 px-4 rounded-xl shadow-md hover:bg-green-500 transition-colors duration-200">
                        Gửi
                    </button>

                </div>
            </div>
        </form>

        <div class="mt-8 sm:mt-12">
            <div class="w-full h-80 sm:h-96 rounded-2xl shadow-md overflow-hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1350.1015134417296!2d105.85038489285202!3d20.93353727063569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135adcd2cf38e3b%3A0xfdd501c15e26da4a!2sTecco%20Garden!5e1!3m2!1svi!2s!4v1760667646100!5m2!1svi!2s"
                    class="w-full h-full" style="border:0;" allowfullscreen loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </div>
@endsection
