@extends('personel.layouts.master')
@section('title', 'Personel Randevuları')
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
        <a href="{{route('personel.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('personel.appointment.index')}}"> Randevular </a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="card pt-4 mb-6 mb-xl-9 ">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title" style="display: block;">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                class="path1"></span><span class="path2"></span></i> <input
                            type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13"
                            placeholder="Randevularda Ara">
                    </div>
                    <!--end::Search-->
                </div>
            </div>
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    <!--begin::Filter-->
                    <div class="w-150px me-3">
                        <!--begin::Select2-->
                        <select class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Durumu"
                                data-kt-ecommerce-order-filter="status">
                            <option></option>
                            <option value="all">Tümü</option>
                            <option value="Onay Bekliyor">Onay Bekliyor</option>
                            <option value="Onaylandı">Onaylandı</option>
                            <option value="Tamamlandı">Tamamlandı</option>
                            <option value="İptal Edildi">İptal Edildi</option>
                        </select>
                        <!--end::Select2-->
                    </div>
                    <!--end::Filter-->

                    <!--begin::Add customer-->
                    <a href="{{route('personel.appointmentCreate.index')}}" class="btn btn-primary me-1">
                        Randevu Oluştur
                    </a>

                    <!--begin::Export-->
                    <!--begin::Export dropdown-->
                    <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                    <!--begin::Menu-->
                    <div id="kt_ecommerce_report_customer_orders_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-ecommerce-export="copy">
                                Panoya Kopyala
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-ecommerce-export="excel">
                                Excel
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-ecommerce-export="csv">
                                CSV
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-ecommerce-export="pdf">
                                PDF
                            </a>
                        </div>
                        <!--end::Menu item-->

                    </div>
                    <!--end::Menu-->
                    <!--end::Export-->
                    <!--end::Add customer-->
                </div>
                <!--end::Toolbar-->

                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none"
                     data-kt-customer-table-toolbar="selected">
                    <div class="fw-bold me-5">
                                                <span class="me-2"
                                                      data-kt-customer-table-select="selected_count"></span> Selected
                    </div>

                    <button type="button" class="btn btn-danger"
                            data-kt-customer-table-select="delete_selected">
                        Delete Selected
                    </button>
                </div>
                <!--end::Group actions-->        </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Müşteri</th>
                        <th class="min-w-125px">Salon</th>
                        <th class="min-w-125px">Hizmetler</th>
                        <th class="min-w-125px">Tarih</th>
                        <th class="min-w-125px">Saat</th>
                        <th class="min-w-125px">Durum</th>
                        <th class="min-w-125px">Toplam Hizmet Fiyatı</th>
                        <th class="text-end min-w-70px">İşlemler</th>
                    </tr>
                    </thead>
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-semibold text-gray-600">

                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        let DATA_URL = "{{route('personel.appointment.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'customerName'},
            {data: 'room_id'},
            {data: 'services'},
            {data: 'start_time'},
            {data: 'clock'},
            {data: 'status'},
            {data: 'servicePrice'},
            {data: 'action'}
        ];
    </script>
    <script>
        var personelName = '{{$personel->name}}'
    </script>
    <script src="/business/assets/js/project/personel-account/appointment/listing.js" ></script>
@endsection
