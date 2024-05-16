@extends('business.layouts.master')
@section('title', 'Personel İzinleri')
@section('styles')
    <style>
        .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
        }
        .flatpickr-calendar{
            z-index: 1060;
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
        Personel İzinleri
    </li>
@endsection
@section('content')
    @include('business.personel.edit.nav')
    <div class="card pt-4 mb-6 mb-xl-9 ">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title" style="display: block;">
                <h2 style="margin-bottom: 10px;margin-top: 5px;">İzinleri</h2>
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
                <a href="" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#stay_off_day_add_modal">İzin Ekle</a>
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
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                        <tr class="text-start text-muted text-uppercase gs-0">
                            <th class="min-w-100px">İzin Başlangıç Tarihi</th>
                            <th class="min-w-100px">İzin Bitiş Tarihi</th>
                            <th class="min-w-100px">Bitmesine Kalan</th>
                            <th class="min-w-100px">Toplam Gün</th>
                            <td class="min-w-100px">İşlemler</td>
                        </tr>
                    </thead>
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-semibold text-gray-600" id="receivableTable">

                    @foreach($stayOffDays as $stay)

                        <tr>
                            <!--begin::Date=-->
                            <td>{{\Illuminate\Support\Carbon::parse($stay->start_time)->format('d.m.Y H:i')}}</td>
                            <!--end::Date=-->
                            <!--begin::order=-->
                            <td>{{\Illuminate\Support\Carbon::parse($stay->end_time)->format('d.m.Y H:i')}}</td>
                            <!--end::order=-->
                            <!--begin::Business=-->
                            <td>
                                @if($stay->end_time < now())
                                    <span class="badge badge-light-success">İzin Bitti</span>
                                @elseif($stay->end_time == now())
                                    <span class="badge badge-light-warning">Son Gün</span>
                                @else
                                    <span class="badge badge-light-info">{{\Illuminate\Support\Carbon::parse($stay->end_time)->diffForHumans()}}</span>
                                @endif
                            </td>
                            <!--end::Business=-->
                            <td>
                                {{ \Carbon\Carbon::parse($stay->start_time)->diffInDays(\Carbon\Carbon::parse($stay->end_time)) }}
                            </td>
                            <!--begin::Status=-->
                            <td>
                                <a class="btn btn-danger btn-sm me-1 off-day-delete-btn" href="#"
                                   data-toggle="popover"
                                   data-object-id="{{$stay->id}}"
                                   data-route="/isletme/ajax/delete/object"
                                   data-model="App\Models\PersonelStayOffDay"
                                   data-content="İzin Kaydını Silmek İstediğinize Eminmisiniz?"
                                   data-delete-type="1"
                                   data-title="İzin">
                                    <i class="fa fa-trash"></i></a>
                            </td>
                            <!--end::Status=-->

                        </tr>
                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    @include('business.personel.edit.stay-off-day.add-modal')
@endsection
@section('scripts')
    <script>
        var personelName = '{{$personel->name}}';
        var personelId = '{{$personel->id}}';

        var flatpickrInstance = $(".formatDateInput").flatpickr({
            altInput: true,
            altFormat: "d F, Y H:i", // Saat bilgisini de içer
            dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
            enableTime: true, // Saat seçicisini etkinleştir
            time_24hr: true, // 24 saat formatını kullan
        });
        var flatpickrInstance2 = $(".formatDateInput2").flatpickr({
            altInput: true,
            altFormat: "d F, Y H:i", // Saat bilgisini de içer
            dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
            enableTime: true, // Saat seçicisini etkinleştir
            time_24hr: true, // 24 saat formatını kullan
        });
    </script>
    <script src="/business/assets/js/project/personels/edit/stay-off-day/listing.js" ></script>
    <script src="/business/assets/js/project/personels/edit/stay-off-day/delete.js" ></script>
    <script src="/business/assets/js/project/personels/edit/stay-off-day/add.js" ></script>

@endsection
