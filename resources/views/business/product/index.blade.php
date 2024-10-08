@extends('business.layouts.master')
@section('title', 'Ürünler')
@section('styles')
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
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Ürünler
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
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                class="path1"></span><span class="path2"></span></i> <input
                            type="text" data-kt-sale-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13"
                            placeholder="Ürünlerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.product.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Eklenme Tarihi</th>
                        <th class="min-w-125px">Ürün Adı</th>
                        <th class="min-w-125px">Fiyatı</th>
                        <th class="min-w-125px">Stok</th>
                        <th class="min-w-125px">Durum</th>
                        <th class="min-w-125px">Barkod</th>
                        <th class="min-w-125px">Satılan</th>
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
        @can('product.create')
        <!--end::Card-->
        @include('business.product.parts.add-product')
        @endcan
    </div>

@endsection
@section('scripts')
    <script>
        let DATA_URL = "{{route('business.product.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'created_at'},
            {data: 'name'},
            {data: 'price'},
            {data: 'piece'},
            {data: 'status'},
            {data: 'barcode'},
            {data: 'total'},
            {data: 'action'}
        ];
    </script>
    <script src="/business/assets/js/project/product/listing/listing.js"></script>
    <script src="/business/assets/js/project/product/listing/add.js"></script>
    @can('stockAlert.view')
        @if($business->lowStockProducts->count() > 0)
            <script>
                $(document).ready(function () {
                    Swal.fire({
                        'icon': "error",
                        'title': "Stok Alarmı",
                        'text' : "Stoğu azalan ürünler var. Stok Durumu Filtresini kullanarak bu ürünleri filtreleyebilirsiniz.",
                        confirmButtonText: "Tamam",
                    });
                });
            </script>
        @endif
    @endcan

@endsection
