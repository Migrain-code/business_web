@extends('business.layouts.master')
@section('title', 'Prim Takibi')
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
        Prim Takibi
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
                <div class="col-lg-6 col-12">
                    <!--begin::Social widget 1-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Kasa</span>

                                <span class="text-muted mt-1 fw-semibold fs-7">Seçtiğiniz Aralıkta türe göre sağlanan kazanç</span>
                            </h3>

                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                               <span class="fw-bold" style="font-size: 1.275rem"></span>
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
                                    <i class="ki-duotone ki-wallet fs-3x text-primary mb-2">
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
                                            Hizmet Gideri
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki toplam hizmet gideri</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($case["servicePrice"])}}</span>
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
                                            Ürün Gideri
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki toplam ürün gideri</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($case["productPrice"])}}</span>
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
                                            Toplam
                                        </a>

                                        <span class="text-muted fw-semibold d-block fs-7">Seçtiğiniz aralıktaki toplam gider</span>
                                    </div>
                                    <!--end:Author-->

                                    <!--begin:Action-->
                                    <span class="fs-4 fw-bold">{{formatPrice($case["total"])}}</span>
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
                <div class="col-lg-6 col-12">
                    <!--begin::Social widget 1-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Personeller</span>

                                <span class="text-muted mt-1 fw-semibold fs-7">Personellere Göre Prim Takibi</span>
                            </h3>

                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <span class="fw-bold" style="font-size: 1.275rem"></span>
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            @foreach($prims as $prim)
                                <!--begin::question-->
                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse"
                                         data-bs-target="#qustion_{{$loop->index}}">
                                        <!--begin::Icon-->
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                        <!--end::Icon-->

                                        <!--begin::Title-->
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">
                                            {{$prim["personelName"]}}
                                        </h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Body-->
                                    <div id="qustion_{{$loop->index}}" class="collapse fs-6 ms-1">
                                        <!--begin::Text-->
                                        <div class="mb-4 text-gray-600 fw-semibold fs-6">
                                           <div class="card p-5">
                                               <div class="d-flex flex-stack p-2">
                                                   <div class="fw-bold">Hizmet Gideri</div>
                                                   <div class="fw-medium">{{formatPrice($prim["servicePrice"])}}</div>
                                               </div>
                                               <div class="separator separator-dashed"></div>
                                               <div class="d-flex flex-stack p-2">
                                                   <div class="fw-bold">Ürün Satış Gideri</div>
                                                   <div class="fw-medium">{{formatPrice($prim["productPrice"])}}</div>
                                               </div>
                                               <div class="separator separator-dashed"></div>
                                               <div class="d-flex flex-stack p-2">
                                                   <div class="fw-bold">Toplam</div>
                                                   <div class="fw-medium">{{formatPrice($prim["total"])}}</div>
                                               </div>
                                               <div class="separator separator-dashed"></div>
                                           </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Content-->


                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed"></div>
                                    <!--end::Separator-->
                                </div>
                                <!--end::question-->
                            @endforeach

                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Social widget 1-->
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
