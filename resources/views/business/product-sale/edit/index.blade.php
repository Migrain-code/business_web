@extends('business.layouts.master')
@section('title', 'Ürün Satışı Düzenle')
@section('styles')
@endsection
@section('toolbar')
    <x-tool-button title="Yeni Ürün Satışı" link="{{route('business.sale.create')}}"></x-tool-button>
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
        <a href="{{route('business.sale.index')}}"> Ürün Satışları </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Ürün Satışı Düzenle
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">

        <!--begin::Form-->
        <form id="kt_ecommerce_edit_order_form" class="form row" data-kt-redirect="{{route('business.sale.index')}}">
            @include('business.product-sale.edit.columns.col-1')
            @include('business.product-sale.edit.columns.col-2')
        </form>
        <!--end::Form-->
    </div>

@endsection
@section('scripts')
    <script src="/business/assets/js/project/product-sale/listing/formrepeater.bundle.js"></script>
    <script src="/business/assets/js/project/product-sale/listing/edit.js"></script>
    <script>

    </script>
@endsection
