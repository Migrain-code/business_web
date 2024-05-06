@extends('business.layouts.master')
@section('title', 'Destek Talebi Detayı')
@section('styles')
    <style>
        .kt_forms_widget_1_editor {
            height: 200px; /* Yüksekliği 200 piksel olarak ayarla */
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.support-center.index')}}"> Destek Merkezi </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Destek Detayı
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row p-7">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                        <!--begin::Ticket view-->
                        <div class="mb-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center mb-12">
                                <!--begin::Icon-->
                                <i class="ki-duotone ki-file-added fs-4qx text-success ms-n2 me-3"><span class="path1"></span><span class="path2"></span></i>
                                <!--end::Icon-->

                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <!--begin::Title-->
                                    <h1 class="text-gray-800 fw-semibold">{{$supportCenter->why('name')}}</h1>
                                    <!--end::Title-->

                                    <!--begin::Info-->
                                    <div class="">
                                        <!--begin::Label-->
                                        <span class="fw-semibold text-muted me-6">Durum: {!! $supportCenter->status("html") !!}</span>
                                        <!--end::Label-->

                                        <!--begin::Label-->
                                        <span class="fw-semibold text-muted me-6">Göndere: <a href="#" class="text-muted text-hover-primary">{{$supportCenter->user->name}}</a></span>
                                        <!--end::Label-->

                                        <!--begin::Label-->
                                        <span class="fw-semibold text-muted">Oluşturma Tarihi: <span class="fw-bold text-gray-600 me-1">{{$supportCenter->created_at->diffForHumans()}}</span>({{$supportCenter->created_at->format('d.m.Y H:i:s')}})</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Heading-->

                            @foreach($supportCenter->responses as $response)
                                <!--begin::Details-->
                                <div class="mb-15">
                                    <!--begin::Description-->
                                    <div class="mb-15 fs-5 fw-normal text-gray-800 border-dashed rounded p-5">
                                        {!! $response->question !!}
                                    </div>
                                    <!--end::Description-->
                                    @if($response->status == 1)
                                        <!--begin::Comments-->
                                        <div class="mb-15">
                                            <!--begin::Comment-->
                                            <div class="overflow-hidden position-relative card-rounded">
                                                <!--begin::Ribbon-->
                                                <div class="ribbon ribbon-triangle ribbon-top-start border-success">
                                                    <!--begin::Ribbon icon-->
                                                    <div class="ribbon-icon mt-n5 ms-n6">
                                                        <i class="ki-duotone ki-check fs-1 text-white mt-n1"></i>
                                                    </div>
                                                    <!--end::Ribbon icon-->
                                                </div>
                                                <!--end::Ribbon-->

                                                <!--begin::Card-->
                                                <div class="card card-bordered w-100">
                                                    <!--begin::Body-->
                                                    <div class="card-body">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100 d-flex flex-stack mb-8">
                                                            <!--begin::Container-->
                                                            <div class="d-flex align-items-center f">
                                                                <!--begin::Author-->
                                                                <div class="symbol symbol-50px me-5">
                                                                    <div class="symbol-label fs-2 fw-bold bg-light-primary text-white">
                                                                        <i class="fa fa-user-secret"></i>
                                                                    </div>
                                                                </div>
                                                                <!--end::Author-->

                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-column fw-semibold fs-5 text-gray-600 text-dark">
                                                                    <!--begin::Text-->
                                                                    <div class="d-flex align-items-center">
                                                                        <!--begin::Username-->
                                                                        <a href="javascript:void(0)" class="text-gray-800 fw-bold text-hover-primary fs-5 me-3">Destek Merkezi</a>
                                                                        <!--end::Username-->
                                                                        @if($response->status == 1)
                                                                            <span class="m-0">{{$response->updated_at->diffForHumans()}}</span>
                                                                        @else
                                                                            Henüz Cevaplanmadı
                                                                        @endif
                                                                    </div>
                                                                    <!--end::Text-->

                                                                    <!--begin::Date-->
                                                                    <span class="text-muted fw-semibold fs-6"></span>
                                                                    <!--end::Date-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Container-->

                                                            <!--end::Actions-->
                                                        </div>
                                                        <!--end::Wrapper-->

                                                        <!--begin::Desc-->
                                                        <p class="fw-normal fs-5 text-gray-700 m-0 mb-10">
                                                            {!! $response->answer !!}
                                                        </p>
                                                        <!--end::Desc-->
                                                        @if($supportCenter->responses->count() == $loop->index+1)
                                                            <div class="kt_forms_widget_1_editor"></div>
                                                            <div class="text-end">
                                                                <button class="btn btn-primary mt-3" type="button" onclick="sendNewResponse()">Gönder</button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                    <!--end::Body-->
                                                </div>
                                                <!--end::Card-->
                                                <!--end::Comments-->

                                            </div>
                                            <!--end::Comment-->
                                        </div>
                                    @else
                                        <div class="alert alert-warning d-flex align-items-center p-5 justify-content-center text-center">
                                            <!--begin::Icon-->
                                            <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                                            <!--end::Icon-->

                                            <!--begin::Wrapper-->
                                            <div class="d-flex flex-column">
                                                <!--begin::Content-->
                                                <span>Cevap Bekleniyor</span>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>

                                    @endif

                                </div>
                                <!--end::Details-->
                            @endforeach

                        </div>
                        <!--end::Ticket view-->

                    </div>
                    <!--end::Content-->

                    @include('business.support-center.show.parts.right-sidebar')
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
@endsection
@section('scripts')
    <script>
        var quill = new Quill('.kt_forms_widget_1_editor', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, 4, 5, 6, false] }], // Başlık seçenekleri
                    ['bold', 'italic', 'underline', 'strike'], // Vurgulama, italik, alt çizgi, çizgi üstü
                    ['blockquote'], // Alıntı, kod bloğu
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }], // Numaralı liste, madde işaretli liste
                    [{ 'script': 'sub'}, { 'script': 'super' }], // Alt simge, üst simge
                    [{ 'indent': '-1'}, { 'indent': '+1' }], // Sola doğru girinti, sağa doğru girinti
                    [{ 'direction': 'rtl' }], // Sağdan sola yazım
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Küçük, normal, büyük, çok büyük
                    [{ 'color': [] }, { 'background': [] }], // Yazı rengi, arka plan rengi
                    [{ 'font': ['Arial', 'Times New Roman', 'Courier New', 'Georgia', 'Verdana', 'Inter', 'Helvatica']}], // Font ailesi
                    [{ 'align': [] }], // Hizalama
                    ['clean'] // Temizleme
                ]
            },
            height:200,
            placeholder: 'Cevabınızı bu alana yazınız',
            theme: 'snow'
        });

    </script>
    <script>
        function sendNewResponse(){
            var content = quill.root.innerHTML;

            $.ajax({
                url: '/isletme/support-center/'+"{{$supportCenter->id}}"+"/edit",
                type: "GET",
                data: {
                    "_token": csrf_token,
                    "description": content,
                },
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        text: res.message,
                        icon: res.status,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam, Devam Et!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (result) {
                        location.reload();
                    });

                },
                error: function (xhr) {
                    var errorMessage = "<ul>";
                    xhr.responseJSON.errors.forEach(function (error) {
                        errorMessage += "<li>" + error + "</li>";
                    });
                    errorMessage += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        html: errorMessage,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        }
    </script>
@endsection
