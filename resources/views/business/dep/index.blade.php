@extends('business.layouts.master')
@section('title', 'Borçlar')
@section('styles')

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
        <a href="{{route('business.dep.index')}}"> Borçlar </a>
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
                            placeholder="Borçlarda Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.dep.parts.toolbar')
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
                        <th class="min-w-125px">Müşteri Adı</th>
                        <th class="min-w-125px">Ödeme Tarihi</th>
                        <th class="min-w-125px">Fiyat</th>
                        <th class="min-w-125px">Ödemeye Kalan</th>
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
        @include('business.dep.parts.add-customer')

    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/dep/listing/listing.js"></script>
    <script src="/business/assets/js/project/dep/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.dep.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'id'},
            {data: 'customer_id'},
            {data: 'payment_date'},
            {data: 'price'},
            {data: 'remainingDate'},
            {data: 'created_at'},
            {data: 'action'}
        ];
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

    <script>
        $(document).ready(function(){
            $("#kt_ecommerce_edit_order_date").flatpickr({
                altInput: true,
                altFormat: "d F, Y H:i", // Saat bilgisini de içer
                dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
                enableTime: true, // Saat seçicisini etkinleştir
                time_24hr: true, // 24 saat formatını kullan
                locale: 'tr',
            });
        });
    </script>
@endsection
