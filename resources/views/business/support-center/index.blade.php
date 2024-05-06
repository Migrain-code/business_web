@extends('business.layouts.master')
@section('title', 'Destek Merkezi')
@section('styles')
    <style>
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
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Destek Merkezi
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        @include('business.support-center.layouts.header')

        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                class="path1"></span><span class="path2"></span></i> <input
                            type="text" data-kt-sale-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13"
                            placeholder="Taleplerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.support-center.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Eklenme Tarihi</th>
                        <th class="min-w-125px">İletişim Türü</th>
                        <th class="min-w-125px">Acil Kodu</th>
                        <th class="min-w-125px">Destek Sebebi</th>
                        <th class="min-w-125px">Durum</th>
                        <th class="min-w-125px">İşlem Tarihi</th>
                        <th class="text-end min-w-70px">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        @include('business.support-center.layouts.modal.create-ticket')
    </div>
@endsection
@section('scripts')
    <script src="/business/assets/js/project/support-center/create-ticket.js"></script>
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
            placeholder: 'Sorunuzu Detaylı Bir şekilde açıklayınız. Gerekirse buraya görsel de ekleyebilirsiniz',
            theme: 'snow'
        });

    </script>
    <script>
        let DATA_URL = "{{route('business.support-center.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'created_at'},
            {data: 'notifications'},
            {data: 'order_number'},
            {data: 'why_is_it'},
            {data: 'is_closed'},
            {data: 'due_date'},
            {data: 'action'}
        ];
    </script>
    <script src="/business/assets/js/project/support-center/listing/listing.js"></script>
@endsection
