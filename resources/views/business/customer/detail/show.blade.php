@extends('business.layouts.master')
@section('title', 'Müşteri Detayı')
@section('styles')
    <style>
        table.dataTable>tbody>tr.child span.dtr-data {
            padding-left: 5px;
            color: white;
            font-weight: 700;
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
        <a href="{{route('business.customer.index')}}"> Müşteriler </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Müşteri Detayı
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            @include('business.customer.detail.component.profile')
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                <div class="scroll-x h-50px overflow-y-hidden">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8" style="width: 1200px">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_overview">Randevular</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_general">Bilgileri</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 cashPoint" data-customer="{{$customer->id}}" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_cashpoint">Parapuanları</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 productSale" data-customer="{{$customer->id}}" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_productSale">Ürün Satışları</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 packageSale" data-customer="{{$customer->id}}" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_packageSale">Paket Satışları</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 receivable" data-customer="{{$customer->id}}" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_recevivable">Salona Borçları</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 payments" data-customer="{{$customer->id}}" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_payments">Ödemeleri</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_comments">Geri Bildirimleri</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 gallery" id="gallleryTab" data-customer="{{$customer->id}}" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_gallery">Galeri</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                </div>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    @include('business.customer.detail.component.tabs.overview')
                    @include('business.customer.detail.component.tabs.edit')
                    @include('business.customer.detail.component.tabs.cash-points')
                    @include('business.customer.detail.component.tabs.productSale')
                    @include('business.customer.detail.component.tabs.packageSale')
                    @include('business.customer.detail.component.tabs.receivable')
                    @include('business.customer.detail.component.tabs.payment')
                    @include('business.customer.detail.component.tabs.comments')
                    @include('business.customer.detail.component.tabs.gallery')
                </div>
                <!--end:::Tab content-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>

@endsection

@section('scripts')
    <script>
        let updateUrl = "{{route('business.customer.update', $customer->id)}}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="/business/assets/js/project/customers/details/fetcInfo.js"></script>
    <script src="/business/assets/js/project/customers/details/fetchPackageSaleList.js"></script>
    <script src="/business/assets/js/project/customers/details/fetchProductSaleList.js"></script>
    <script src="/business/assets/js/project/customers/details/fetchReceviableList.js"></script>
    <script src="/business/assets/js/project/customers/details/fetchPaymentList.js"></script>
    <script src="/business/assets/js/project/customers/details/fetchGalleryList.js"></script>
    <script src="/business/assets/js/project/customers/details/update-profile.js"></script>
    @if($customer->city_id)
        <script>

            // ilçe bilgisini seçtir
            var customerDistrictId = parseInt('{{$customer->district_id}}');
            let id = $('[name="city_id"]').val();
            var district = $('[name="district_id"]');
            district.empty();
            $.ajax({
                url: '/isletme/ajax/get/district',
                type: "POST",
                data: {
                    "_token": csrf_token,
                    'id': id,
                },
                dataType: "JSON",
                success: function (res) {
                    $.each(res, function (index, item) {

                        var selected = (customerDistrictId === item.id) ? 'selected' : '';

                        district.append('<option value="' + item.id + '" ' + selected + '>' + item.name + '</option>');

                    });
                }
            });
        </script>
    @endif
    <script>
        $(document).ready(function (){
            $('#datatable_appointment').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.2/i18n/tr.json"
                },
                responsive: true,
                "info": false,

            });
        });
    </script>

@endsection
