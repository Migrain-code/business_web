@extends('business.layouts.master')
@section('title', 'İzinler')
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
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.dep.index')}}"> İzinler </a>
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
                            placeholder="İzinlerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.permission.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            #
                        </th>
                        <th class="min-w-125px">Personel Adı</th>
                        <th class="min-w-125px">Başlangıç Tarihi</th>
                        <th class="min-w-125px">Bitiş Tarihi</th>
                        <th class="min-w-125px">İzin Bitişine Kalan Gün Sayısı</th>
                        <th class="min-w-125px">İşlem Tarihi</th>
                        <th class="min-w-70px">İşlemler</th>
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

        <!--begin::Modals-->
        <!--begin::Modal - Customers - Add-->
        @include('business.permission.parts.add-customer')

    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/personel-stay-off-day/listing/listing.js"></script>
    <script src="/business/assets/js/project/personel-stay-off-day/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.personel-stay-off-day.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'id'},
            {data: 'personel_id'},
            {data: 'start_time'},
            {data: 'end_time'},
            {data: 'remainingDate'},
            {data: 'created_at'},
            {data: 'action'}
        ];
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

    <script>
        $(document).ready(function(){
            $(".datePickerInput").flatpickr({
                altInput: true,
                altFormat: "d F, Y H:i", // Saat bilgisini de içer
                dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
                enableTime: true, // Saat seçicisini etkinleştir
                time_24hr: true, // 24 saat formatını kullan
                locale: 'tr',
            });
            $("#listType").flatpickr({
                altInput: true,
                altFormat: "d F, Y", // Saat bilgisini de içer
                dateFormat: "Y-m-d", // Tarih ve saat formatını belirle
                locale: 'tr',
            });

        });
    </script>
@endsection
