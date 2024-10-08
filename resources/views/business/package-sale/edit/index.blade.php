@extends('business.layouts.master')
@section('title', 'Paket Satış Detayı')
@section('styles')

@endsection
@section('toolbar')
    <x-tool-button title="Yeni Paket Satışı" link="{{route('business.package-sale.index')}}"></x-tool-button>
    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_policy"><i class="fa fa-paper-plane"></i> Sözleşme Ekle</button>
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
        <a href="{{route('business.package-sale.index')}}"> Paket Satışları </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Paket Bilgileri
    </li>
    <!--end::Item-->
@endsection

@section('content')
    <div id="kt_app_content" class="app-content ">
        @can('packageSale.summary.show')
         @include('business.package-sale.edit.columns.carts')
        @endcan
        <!--begin::Form-->
        <form id="kt_ecommerce_edit_order_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{route('business.sale.index')}}">
            @include('business.package-sale.edit.columns.col-1')
            @include('business.package-sale.edit.columns.col-2')
        </form>
        <!--end::Form-->
    </div>
    @include('business.package-sale.edit.modals.add-payment')
    @include('business.package-sale.edit.modals.add-usage')
    @include('business.package-sale.edit.modals.add-policy')

@endsection
@section('scripts')
    <script>
        var packageSaleId = "{{$packageSale->id}}"
    </script>
    <!-- Ödeme İşlemleri -->
    <script src="/business/assets/js/project/package-sale/edit/fetchPaymentList.js"></script>
    <script src="/business/assets/js/project/package-sale/edit/delete-payment.js"></script>
    <script src="/business/assets/js/project/package-sale/edit/add-payment.js"></script>
    <!-- Kullanım İşlemleri -->
    <script src="/business/assets/js/project/package-sale/edit/usage/fetchUsageList.js"></script>
    <script src="/business/assets/js/project/package-sale/edit/usage/delete-usage.js"></script>
    <script src="/business/assets/js/project/package-sale/edit/usage/add-usage.js"></script>

    <script src="/business/assets/js/project/package-sale/listing/edit.js"></script>

    <script>
        $(".formatDateInput").flatpickr({
            altInput: true,
            altFormat: "d F, Y H:i", // Saat bilgisini de içer
            dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
            enableTime: true, // Saat seçicisini etkinleştir
            time_24hr: true, // 24 saat formatını kullan
        });
    </script>

    <script>
        $('.printFile').on('click', function(e) {
            e.preventDefault(); // Tıklama eylemini engelle
            var fileUrl = $(this).data('file'); // data-file özelliğindeki değeri al
            var newWindow = window.open(fileUrl, '_blank'); // Yeni sekme aç
            if (newWindow) {
                newWindow.onload = function() {
                    newWindow.print(); // Yeni sekmeyi yazdır
                };
            }
        });
    </script>
@endsection
