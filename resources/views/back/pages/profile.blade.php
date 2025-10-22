@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Tài khoản</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active color-[#4AB14B]" aria-current="page">
                            Tài khoản
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @livewire('admin.profile')
@endsection

@push('scripts')
    <script>
        const cropper = new Kropify('#profilePictureFile', {
            aspectRatio: 1,
            viewMode: 1,
            preview: 'img#profilePicturePreview',
            processURL: '{{ route('admin.update_profile_picture') }}',
            requestMethod: 'POST',
            maxSize: 2 * 1024 * 1024, // 2MB
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            showLoader: true,
            animationClass: 'pulse',

            cancelButtonText: 'Cancel',
            resetButtonText: 'Reset',
            cropButtonText: 'Crop & Update',
            maxWoH: 500,

            onDone: function(response) {
                if (!response) {
                    console.error("Không có dữ liệu phản hồi từ server.");
                    return;
                }

                console.log('Upload thành công:', response);
                if (response.status == 1) {
                    $().notifa({
                        vers: 1,
                        cssClass: 'success',
                        html: response.message,
                        delay: 2500
                    });
                } else {
                    $().notifa({
                        vers: 1,
                        cssClass: 'error',
                        html: response.message,
                        delay: 2500
                    });
                }
            },
            onError: function(msg) {
                console.error('Lỗi:', msg);
            }
        });
    </script>
@endpush
