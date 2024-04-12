@extends('business.layouts.master')
@section('title', 'Kasa')
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
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Kasa
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->

                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.case.parts.toolbar')
            </div>
            <!--end::Card header-->

            <div class="row mx-5">
                <div class="col-6">
                    <!--begin::Social widget 1-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Toplam Gelir</span>

                                <span class="text-muted mt-1 fw-semibold fs-7">Seçtiğiniz Aralıkta Ne kadar gelir sağlanmış</span>
                            </h3>

                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                               <span class="fw-bold" style="font-size: 1.275rem">{{formatPrice($closingBalance["total"])}}</span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-5">

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-tag fs-3x text-primary mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Nakit
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki nakit gelir</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($closingBalance["cashTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-4"></div>
                            <!--end::Separator-->

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-credit-cart fs-3x text-primary mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Kredi Kartı
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki kredi kartı gelir</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($closingBalance["creditTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-4"></div>
                            <!--end::Separator-->

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-send fs-3x text-primary mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Eft/Havale
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki eft / havale gelir</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($closingBalance["eftTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-4"></div>
                            <!--end::Separator-->

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-bill fs-3x text-primary mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Diğer
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki diğer ödeme gelir</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($closingBalance["otherTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Social widget 1-->
                </div>
                <div class="col-6">
                    <!--begin::Social widget 1-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Toplam Gider</span>

                                <span class="text-muted mt-1 fw-semibold fs-7">Seçtiğiniz Aralıkta Ne kadar gider yapılmış</span>
                            </h3>

                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <span class="fw-bold" style="font-size: 1.275rem">{{formatPrice($totalExpense["total"])}}</span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-5">

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-tag fs-3x text-warning mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Nakit
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki nakit gider</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($totalExpense["cashTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-4"></div>
                            <!--end::Separator-->

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-credit-cart fs-3x text-warning mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Kredi Kartı
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki kredi kartı gider</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($totalExpense["creditTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-4"></div>
                            <!--end::Separator-->

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-send fs-3x text-warning mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Eft/Havale
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki eft / havale gider</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($totalExpense["eftTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-4"></div>
                            <!--end::Separator-->

                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-40px me-5">
                                    <i class="ki-duotone ki-bill fs-3x text-warning mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Section-->
                                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                    <!--begin:Author-->
                                    <div class="flex-grow-1 me-2">
                                        <a href="javascript:void(0)"
                                           class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                            Diğer
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki diğer ödeme gider</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($totalExpense["otherTotal"])}}</span>
                                    <!--end:Action-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Social widget 1-->
                </div>
                <div class="col-12">
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Kapanış Bakiyesi</span>

                                <span class="text-muted mt-1 fw-semibold fs-7">Seçtiğiniz Aralıkta kasada kalan tutar</span>
                            </h3>

                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <span class="fw-bold" style="font-size: 1.275rem">{{formatPrice($closingBalance["closedTotal"])}}</span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>

@endsection
@section('scripts')
    <script>
        $('#listType').on('change', function (){
           $('#listTypeForm').submit();
        });
    </script>
@endsection
