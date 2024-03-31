@extends('business.layouts.master')
@section('title', 'Adisyonlar')
@section('styles')
    <style>
        .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Adisyonlar
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
                            type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13"
                            placeholder="Adisyonlarda Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

               @include('business.adission.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Müşteri</th>
                        <th class="min-w-125px">Telefon Numarası</th>
                        <th class="min-w-125px">Hizmetler</th>
                        <th class="min-w-125px">Tarih</th>
                        <th class="min-w-125px">Saat</th>
                        <th class="min-w-125px">Durum</th>
                        <th class="min-w-125px">Toplam Hizmet Fiyatı</th>
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

    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/adission/listing.js"></script>

    <script>
        let DATA_URL = "{{route('business.adission.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'customerName'},
            {data: 'customerPhone'},
            {data: 'services'},
            {data: 'start_time'},
            {data: 'clock'},
            {data: 'status'},
            {data: 'servicePrice'},
            {data: 'action'}
        ];
    </script>

@endsection
