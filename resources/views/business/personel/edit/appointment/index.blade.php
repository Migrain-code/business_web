@extends('business.layouts.master')
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
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.personel.index')}}"> Personeller </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.personel.index', $personel->id)}}"> Personel Detayı </a>
    </li>

    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Personel Randevuları
    </li>
@endsection
@section('content')
    @include('business.personel.edit.nav')
    <div class="card pt-4 mb-6 mb-xl-9 ">
        @can('appointment.list')
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title" style="display: block;">
                <h2 style="margin-bottom: 10px;margin-top: 5px;">Randevuları</h2>
            </div>
            <div class="d-flex align-items-center">
                <!--begin::Filter-->
                <div class="w-150px me-3">
                    <!--begin::Select2-->
                    <select name="listTypeReceivable" class="form-select form-select-solid" data-control="select2"
                            data-hide-search="true" data-placeholder="Tarih Aralığı"
                            data-kt-ecommerce-order-filter="status">
                        <option></option>
                        <option value="all">Tümü</option>
                        <option value="thisWeek">Bu Hafta</option>
                        <option value="thisMonth">Bu Ay</option>
                        <option value="thisYear">Bu Yıl</option>
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Filter-->
                <div id="kt_ecommerce_report_customer_receivable_export">

                </div>
                <!--begin::Export dropdown-->
                <button type="button" style="padding: 10px 20px !important;" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Rapor
                </button>
                <!--begin::Menu-->
                <div id="kt_ecommerce_report_customer_orders_export_menu_receivable" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-receivable="copy">
                            Panoya Kopyala
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-receivable="excel">
                            Excel
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-receivable="csv">
                            CSV
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-receivable="pdf">
                            PDF
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-receivable="print">
                            Yazdır
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
                <!--end::Export-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="receivableDataTable">
                    <thead>
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th class="min-w-100px">Tarih</th>
                            <th class="min-w-100px">Rand No.</th>
                            <th class="min-w-100px">İşletme</th>
                            <th>Randevu Durumu</th>
                            <th>Fiyat</th>
                            <td>İşlemler</td>
                        </tr>
                    </thead>
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-semibold text-gray-600" id="receivableTable">
                    @forelse($personel->appointments()->take(30)->get() as $appointment)
                        <tr>
                            <!--begin::Date=-->
                            <td>{{\Illuminate\Support\Carbon::parse($appointment->appointment->services()->where('personel_id', $personel->id)->first()->start_time)->translatedFormat('d.m.Y, H:i')}}</td>
                            <!--end::Date=-->
                            <!--begin::order=-->
                            <td>
                                <a href="{{route('business.appointment.show', $appointment->appointment->id)}}" class="text-gray-600 text-hover-primary mb-1">#{{$appointment->appointment_id}}</a>
                            </td>
                            <!--end::order=-->
                            <!--begin::Business=-->
                            <td>
                                <a href="{{route('business.appointment.show', $appointment->appointment->id)}}" class="text-gray-600 text-hover-primary mb-1">#{{$appointment->appointment->business->name}}</a>
                            </td>
                            <!--end::Business=-->
                            <!--begin::Status=-->
                            <td>
                                {!! $appointment->appointment->status("html") !!}
                            </td>
                            <!--end::Status=-->
                            <!--begin::Amount=-->
                            <td>₺{{number_format(calculateTotal($appointment->appointment->services()->where('personel_id', $personel->id)->get()), 2)}}</td>
                            <!--end::Amount=-->
                            <td>
                                <a class="btn btn-primary" href="#" data-bs-toggle="tooltip" title="Randevu Detayı">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>

                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        @else
            <div class="card-body">
                <x-forbidden-component title="Yetkisiz Erişim" message="Randevuları görüntülemek için yetkiniz bulunmamaktadır"></x-forbidden-component>
            </div>
        <!--end::Card body-->
        @endcan
    </div>
@endsection
@section('scripts')
    <script>
        var personelName = '{{$personel->name}}'
    </script>
    <script src="/business/assets/js/project/personels/edit/appointment/listing.js" ></script>
@endsection
