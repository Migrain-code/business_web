@extends('business.layouts.master')
@section('title', 'Adisyonlar')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-wrapper {
            width: 100%;
        }

        .ts-dropdown [data-selectable] .highlight {
            background: rgb(129 129 129);
            border-radius: 14px;
            padding: 10px;
        }

        .ts-wrapper.single .ts-control, .ts-wrapper.single .ts-control input {
            background-color: #f5f8fa;
            border: none;
            padding: 13px;
            cursor: pointer;
            border-radius: 7px;
            font-size: 14.3px;
            font-family: 'Inter';
        }

        .ts-wrapper.single .ts-control, .ts-wrapper.single .ts-control input::placeholder {
            color: var(--kt-input-solid-placeholder-color);
            font-weight: 900;
        }

        .ts-control, .ts-wrapper.single.input-active .ts-control {
            background: #f5f8fa;
            cursor: text;
        }

        .header {
            background: transparent;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            display: block;
        }

        .ts-dropdown.plugin-optgroup_columns .ts-dropdown-content {
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 1360px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl {
                max-width: 1200px;
            }
        }

        .feather-arrow-right:before {
            content: "\e912";
            margin-right: 5px !important;
        }
        .btn-check:checked + .btn.btn-light-success, .btn-check:active + .btn.btn-light-success, .btn.btn-light-success:focus:not(.btn-active), .btn.btn-light-success:hover:not(.btn-active), .btn.btn-light-success:active:not(.btn-active), .btn.btn-light-success.active, .btn.btn-light-success.show, .show > .btn.btn-light-success {
            color: white;
            border-color: #6E6E6E !important;
            background-color: #6E6E6E !important;
        }
        .btn.btn-outline:not(.btn-outline-dashed) {
            border: 1px solid var(--kt-input-border-color);
            border-color: #28A745 !important;
            background-color: #28A745 !important;
        }
        .nav-line-tabs .nav-item .nav-link.active, .nav-line-tabs .nav-item.show .nav-link, .nav-line-tabs .nav-item .nav-link:hover:not(.disabled) {
            background-color: transparent;
            border: 0;
            border-bottom: 1px solid var(--kt-primary);
            transition: color 0.2s ease;
            color: black;
        }
        .nav-line-tabs {
            border-bottom-width: 1px;
            border-bottom-style: solid;
            border-bottom-color: var(--kt-border-color);
            padding: 0px 20px !important;
            padding-top: 20px !important;
            font-size: 1.2rem !important;
            font-weight: bold;
            color: black;
        }.modal.show .modal-dialog {
             transform: none;
             box-shadow: 1px 3px 15px #7975758f !important;
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
                            type="text" data-kt-customer-table-filter="search" id="searchArea"
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
                        <th>#</th>
                        <th class="min-w-125px">Müşteri</th>
                        <th class="min-w-125px">Telefon Numarası</th>
                        <th class="min-w-125px">Hizmetler</th>
                        <th class="min-w-125px">Tarih</th>
                        <th class="min-w-125px">Saat</th>
                        <th class="min-w-125px">Durum</th>
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

    </div>

    @can('adission.create')
        @include('business.appointment.modals.add-new-appointment')
        @include('business.appointment-create.modal.add-customer')
    @endcan
@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/adission/listing.js"></script>
    <script>
        $("#time_select").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            onOpen: function() {
                document.activeElement.blur(); // Klavyeyi gizle
            }
        });
    </script>
    <script>
        let DATA_URL = "{{route('business.adission.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'id'},
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
    <script src="/business/assets/js/project/appointment/add-customer.js"></script>
    <script src="/business/assets/js/project/appointment/addission.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <script>
        $(".datePickerSelect").flatpickr({
            time_24hr: true, // 24 saat formatını kullan
            locale: 'tr',
            onOpen: function() {
                document.activeElement.blur(); // Klavyeyi gizle
            }
        });
    </script>
    <script src="/business/assets/js/project/speed-appointment/listing.js"></script>

@endsection
