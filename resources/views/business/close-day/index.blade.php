@extends('business.layouts.master')
@section('title', 'Kapalı Günler')
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
        <a href="{{route('business.dep.index')}}"> Kapalı Günler </a>
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
                            placeholder="Kapalı Günlerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.close-day.parts.toolbar')
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
                        <th class="min-w-125px">Başlangıç Tarihi</th>
                        <th class="min-w-125px">Bitiş Tarihi</th>
                        <th class="min-w-125px">Durum</th>
                        <th class="min-w-125px">İşlem Tarihi</th>
                        @can('closeDay.delete')
                        <th class="min-w-70px">İşlemler</th>
                        @endcan
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
        @can('closeDay.create')
            @include('business.close-day.parts.add-customer')
        @endcan

    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/close-day/listing/listing.js"></script>
    <script src="/business/assets/js/project/close-day/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.close-day.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'id'},
            {data: 'start_time'},
            {data: 'end_time'},
            {data: 'status'},
            {data: 'created_at'},
            @can('closeDay.delete')
            {data: 'action'}
            @endcan
        ];
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

    <script>
        $(document).ready(function(){
            $(".datePickerInput").flatpickr({
                altInput: true,
                altFormat: "d F, Y", // Saat bilgisini de içer
                dateFormat: "Y-m-d", // Tarih ve saat formatını belirle
                enableTime: false, // Saat seçicisini etkinleştir
                locale: 'tr',
            });
        });
    </script>
@endsection
