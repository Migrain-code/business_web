@extends('personel.layouts.master')
@section('title', 'Personel Kasası')
@section('styles')

@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Kasa
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="card pt-4 mb-6 mb-xl-9 ">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title" style="display: block;">
                    <h2 style="margin-bottom: 10px;margin-top: 5px;">Kasa</h2>
                </div>
                <div class="d-flex align-items-center">
                    <!--begin::Filter-->
                    <div class="w-150px me-3">
                        <!--begin::Select2-->
                        <form id="listTypeSelector">
                            <select name="listType" class="form-select form-select-solid" id="listTypeCase" data-control="select2"
                                    data-hide-search="true" data-placeholder="Tarih Aralığı"
                                    data-kt-ecommerce-order-filter="status">
                                <option></option>
                                <option value="thisYesterday" @selected(request()->listType == "thisYesterday")>Dün</option>
                                <option value="thisDay" @selected(request()->listType == "thisDay")>Bugün</option>
                                <option value="thisWeek" @selected(request()->listType == "thisWeek")>Bu Hafta</option>
                                <option value="thisMonth" @selected(request()->listType == "thisMonth")>Bu Ay</option>
                                <option value="thisYear" @selected(request()->listType == "thisYear")>Bu Yıl</option>
                            </select>
                        </form>
                        <!--end::Select2-->
                    </div>
                    <!--end::Filter-->
                    <div id="kt_ecommerce_report_customer_receivable_export">

                    </div>
                    <!--begin::Export dropdown-->
                    <button type="button" style="padding: 10px 20px !important;" onclick="printCase()" class="btn btn-light-primary">
                        <i class="ki-duotone ki-printer fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Yazdır
                    </button>
                    <!--begin::Menu-->
                    <!--end::Menu-->
                    <!--end::Export-->
                </div>
            </div>
            <!--end::Card header-->
        </div>
        <div class="row" id="printTable">
            <div class="col-6">
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">Toplam Ciro</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fw-bold fs-2">
                            ₺{{$totalCiro}} <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                            <div class="fs-7 fw-normal text-muted">Personelin Seçilen tarih aralığındaki cirosu.</div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <div class="col-6">
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">Personel Payına Düşen Ücret</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fw-bold fs-2">
                            ₺{{$progressPayment}} <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                            <div class="fs-7 fw-normal text-muted">Personelin Seçilen tarih aralığındaki satışlarından ve hizmetlerinden payında düşen ücret.</div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <div class="col-6">
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">İçerideki Bakiye</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fw-bold fs-2">
                            ₺{{$insideBalance}} <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                            <div class="fs-7 fw-normal text-muted">Personele ödenecek tutar.</div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <div class="col-6">
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">Ödenen Bakiye</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="fw-bold fs-2">
                            ₺{{$balancePayed}} <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                            <div class="fs-7 fw-normal text-muted">Personele ödediğiniz tutar.</div>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var personelName = '{{$personel->name}}'
    </script>
    <script src="/business/assets/js/project/personels/edit/case/print.js"></script>
@endsection
