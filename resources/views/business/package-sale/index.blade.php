@extends('business.layouts.master')
@section('title', 'Paket Satışları')
@section('styles')
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
        Paket Satışları
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
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
                            placeholder="Ürün Satışlarında Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.package-sale.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Satış Tarihi</th>
                        <th class="min-w-125px">Müşteri</th>
                        <th class="min-w-125px">Hizmet</th>
                        <th class="min-w-125px">Satıcı</th>
                        <th class="min-w-125px">Adet</th>
                        <th class="min-w-125px">Tür</th>
                        <th class="min-w-125px">Toplam Tutar</th>
                        <th class="text-end min-w-70px">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->    </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        @include('business.package-sale.parts.add-package')
    </div>
@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/package-sale/listing/listing.js"></script>
    <script src="/business/assets/js/project/package-sale/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.package-sale.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'created_at'},
            {data: 'customerName'},
            {data: 'serviceName'},
            {data: 'personelName'},
            {data: 'amount'},
            {data: 'type'},
            {data: 'total'},
            {data: 'action'}
        ];
    </script>

    <script>
        $(".formatDateInput").flatpickr({
            altInput: true,
            altFormat: "d F, Y H:i", // Saat bilgisini de içer
            dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
            enableTime: true, // Saat seçicisini etkinleştir
            time_24hr: true, // 24 saat formatını kullan
        });
    </script>
@endsection
