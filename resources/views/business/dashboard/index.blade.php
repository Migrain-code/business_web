@extends('business.layouts.master')
@section('title', 'Dashboard')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       <a href="{{route('business.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content ">

        <!--begin::Row-->
        @include('business.dashboard.parts.charts')

        <!--end::Row-->
        <div class="row">
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 align-items-center">
                <a href="https://apptest.hizlirandevu.com.tr/business/appointment">
                    <div class="widget-stat card ">
                        <div class="card-body rounded p-15" style="background-color: #6a23ff">
                            <h1 class="text-white"><i class="fa fa-calendar-check"
                                                      style="color:white;font-size: 30px"></i>
                                Randevular</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="https://apptest.hizlirandevu.com.tr/business/customer">
                    <div class="widget-stat card">
                        <div class="card-body rounded p-15" style="background-color: #9568ff">
                            <h1 class="text-white"><i class="fa fa-user-circle"
                                                      style="color:white;font-size: 30px"></i>
                                Müşteriler</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="https://apptest.hizlirandevu.com.tr/business/personel">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-warning p-15">
                            <h1 class="text-white"><i class="fa fa-person"
                                                      style="color:white;font-size: 30px"></i>
                                Personeller</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="https://apptest.hizlirandevu.com.tr/business/businessService">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-primary p-15">
                            <h1 class="text-white"><i class="fa fa-gear"
                                                      style="color:white;font-size: 30px"></i> Hizmetler
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="https://apptest.hizlirandevu.com.tr/business/product">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-black p-15">
                            <h1 class="text-white"><i class="fa fa-box-open"
                                                      style="color:white;font-size: 30px"></i> Ürünler
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="https://apptest.hizlirandevu.com.tr/business/gallery">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-info p-15">
                            <h1 class="text-white"><i class="fa fa-image"
                                                      style="color:white;font-size: 30px"></i> Galeri
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="card mt-3">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title d-flex w-100" style="justify-content: space-between">
                    <!--begin::Search-->
                    <div>
                        <h3>Son Kayıt Olan Müşteriler</h3>
                    </div>
                    <div class="d-flex align-items-center position-relative my-1 me-2">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                class="path1"></span><span class="path2"></span></i>
                        <input type="text"
                               data-kt-user-table-filter="search"
                               class="form-control form-control-solid w-250px ps-13"
                               placeholder="Müşteri Ara">
                    </div>

                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body py-4">

                <!--begin::Table-->
                @include('business.dashboard.parts.user-table')
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Content-->
@endsection
@section('scripts')

@endsection
