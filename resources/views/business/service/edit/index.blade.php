@extends('business.layouts.master')
@section('title', 'Hizmet Detayı')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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
        <a href="{{route('business.service.index')}}"> Hizmetler </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Hizmet Bilgileri
    </li>
    <!--end::Item-->
@endsection

@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="swiper-container mb-5">
            <div class="swiper-wrapper">
                @include('business.service.edit.columns.swipers')
            </div>
        </div>

        <!--begin::Form-->
        @include('business.service.edit.columns.col-1')
        <!--end::Form-->
    </div>

@endsection
@section('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var serviceId = "{{$service->id}}";
    </script>
    <script src="/business/assets/js/project/service/listing/edit.js"></script>

    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 4, // Her satırda gösterilecek kart sayısı
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
                    slidesPerView: 4,
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
        $(document).on('change', '[name="category_id"]', function () {
            let id = $(this).val();
            var service = $('[name="service_id"]');
            service.empty();
            $.ajax({
                url: '/isletme/service/create',
                type: "GET",
                data: {
                    "_token": csrf_token,
                    'category_id': id,
                },
                dataType: "JSON",
                success: function (res) {
                    $.each(res, function (index, item) {
                        service.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
        });
    </script>
@endsection
