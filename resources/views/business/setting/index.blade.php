@extends('business.layouts.master')
@section('title', 'İşletme Bilgileri')
@section('styles')
    <style>
        .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
        }
        #kt_forms_widget_1_editor {
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

    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       İşletme Ayarları
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
    <!--begin::Form-->
        <form id="kt_ecommerce_edit_personel_form" method="post" enctype="multipart/form-data" action="{{route('business.settings.update')}}" class="form d-flex flex-column flex-lg-row">
            @csrf

            <!--begin::Aside column-->
            @include('business.setting.parts.col-1')
            <!--end::Aside column-->
            <!--begin::Main column-->
            @include('business.setting.parts.col-2')
            <!--end::Main column-->
            <!--begin::Service column-->
            <!--end::Service column-->
        </form>
        <div class="d-flex justify-content-end flex-row">

            <!--begin::Button-->
            <button type="submit" id="kt_ecommerce_add_product_submit" onclick="sendForm()" class="btn btn-primary w-100 mt-3">
                        <span class="indicator-label">
                            Kaydet
                        </span>
            </button>
            <!--end::Button-->
        </div>
    <!--end::Form-->
    </div>
@endsection
@section('scripts')

    <script>

        $(".timeSelector").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

    </script>
    <script>
        var quill = new Quill('#kt_forms_widget_1_editor', {
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
                    ['clean'], // Temizleme
                    ['image']
                ]
            },
            height:200,
            placeholder: 'İşletmenizin tanıtım sayfasında görüntülenecek olan hakkımızda metnidir',
            theme: 'snow'
        });
        function sendForm(){
            var content = quill.root.innerHTML;
            $('#about').val(content);
            $('#kt_ecommerce_edit_personel_form').submit()
        }
    </script>

@endsection
