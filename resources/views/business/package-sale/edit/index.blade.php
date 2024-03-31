@extends('business.layouts.master')
@section('title', 'Paket Satış Detayı')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
@endsection
@section('toolbar')
    <x-tool-button title="Yeni Paket Satışı" link="{{route('business.package-sale.index')}}"></x-tool-button>
    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_policy"><i class="fa fa-paper-plane"></i> Sözleşme Ekle</button>
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
        <div class="swiper-container mb-5">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <!--begin::Col-->
                    <div class="col-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->total}}₺</span>

                                    <div class="fw-bold fs-4 text-white">
                                        <span class="d-block">Paketin Toplam</span>
                                        <span class="">Tutarı</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->

                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <div class="swiper-slide">
                    <!--begin::Col-->
                    <div class="col-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #0da141;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->payeds->sum('price')}}₺</span>

                                    <div class="fw-bold fs-4 text-white">
                                        <span class="d-block">Paketin Ödenen</span>
                                        <span class="">Tutarı</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->

                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <div class="swiper-slide">
                    <!--begin::Col-->
                    <div class="col-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #9b0b62;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->total - $packageSale->payeds->sum('price')}}₺</span>

                                    <div class="fw-bold fs-4 text-white">
                                        <span class="d-block">Paketin Kalan</span>
                                        <span class="">Ödemesi</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->

                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <div class="swiper-slide">
                    <div class="col-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: rgba(255,255,255,0.38);background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                            <span class="fs-3hx text-white fw-bold me-6">
                                {{$packageSale->amount}}
                            </span>

                                    <div class="fw-bold fs-4 text-white">
                                        <span class="d-block">Paketin Toplam</span>
                                        <span class="">{{$packageSale->packageType("name")}} Limiti</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->

                        </div>
                        <!--end::Card widget 3-->
                    </div>
                </div>
                <div class="swiper-slide">
                    <!--begin::Col-->
                    <div class="col-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #0da141;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->usages->sum('amount')}}</span>

                                    <div class="fw-bold fs-4 text-white">
                                        <span class="d-block">Paketin Kullanılan</span>
                                        <span class="">{{$packageSale->packageType('name')}}</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->

                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
                <div class="swiper-slide">
                    <!--begin::Col-->
                    <div class="col-12">
                        <!--begin::Card widget 3-->
                        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #9b0b62;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-end mb-3">
                                <!--begin::Info-->
                                <div class="d-flex flex-column">
                                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->amount - $packageSale->usages->sum('amount')}}</span>

                                    <div class="fw-bold fs-4 text-white">
                                        <span class="d-block">Paketin Kalan</span>
                                        <span class="">{{$packageSale->packageType('name')}}</span>
                                    </div>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Card body-->

                        </div>
                        <!--end::Card widget 3-->
                    </div>
                    <!--end::Col-->
                </div>
            </div>
        </div>

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
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
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
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 6, // Her satırda gösterilecek kart sayısı
            spaceBetween: 10, // Kartlar arasındaki boşluk
            breakpoints: {
                // 300 ve üstü için
                300: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                // 640px ve üstü için
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                // 1024px ve altı için
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 30
                },
                // 1025 ve üstü için
                1025: {
                    slidesPerView: 4,
                    spaceBetween: 30
                }
            },
            //loop: true,
            initialSlide: 4,
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
