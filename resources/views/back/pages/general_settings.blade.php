@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Cài đặt chung</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.settings') }}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $pageTitle }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="pd-20 card-box mb-4">
        @livewire('admin.settings')
    </div>
@endsection

@push('scripts')
    <script>
        $('input[type="file"][name="site_logo"]').ijaboViewer({
            preview: '#preview_site_logo',
            imageShape: 'rectangular',
            allowedExtensions: ['png', 'jpg'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {}
        })

        $('#updateLogoForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            var inputVal = $(form).find('input[type="file"]').val();
            var errorElement = $(form).find('span.text-danger');
            errorElement.text('');

            if (inputVal.length > 0) {
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {},
                    success: function(data) {
                        if (data.status == 1) {
                            $(form)[0].reset();
                            $().notifa({
                                vers: 2,
                                cssClass: 'success',
                                html: data.message,
                                delay: 3000
                            });
                            $('img.site_logo').each(function() {
                                $(this).attr('src', '/' + data.image_path);
                            });
                        } else {
                            $().notifa({
                                vers: 2,
                                cssClass: 'error',
                                html: data.message,
                                delay: 3000
                            });
                        }
                    }
                })
            } else {
                errorElement.text('Vui lòng chọn file ảnh');
            }
        });

        $('input[type="file"][name="site_favicon"]').ijaboViewer({
            preview: 'img#preview_site_favicon',
            imageShape: ['rectangular', 'square'],
            allowedExtensions: ['png', 'ico'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {

            }
        });

        $('#updateFaviconForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            var inputVal = $(form).find('input[type="file"]').val();
            var errorElement = $(form).find('span.text-danger');
            errorElement.text('')

            if (inputVal.length > 0) {
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {},
                    success: function(data) {
                        if (data.status == 1) {
                            $(form)[0].reset();
                            var linkElement = document.querySelector('link[rel="icon"]');
                            linkElement.href='/'+data.image_path;
                            $().notifa({
                                vers: 2,
                                cssClass: 'success',
                                html: data.message,
                                delay: 2700
                            });
                        }else{
                            $().notifa({
                                vers:2,
                                cssClass: 'error',
                                html: data.message,
                                delay: 2700
                            })
                        }
                    }
                });
            } else {
                errorElement.text('Vui lòng chọn file ảnh');
            }

        })
    </script>
@endpush
