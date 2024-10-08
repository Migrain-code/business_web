@extends('business.layouts.master')
@section('title', 'Personel Düzenle')
@section('styles')
    <style>
        .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
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
        <a href="{{route('business.personel.index')}}"> Personeller </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Personel Düzenle
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        @include('business.personel.edit.nav')
    <!--begin::Form-->
        <form id="kt_ecommerce_edit_personel_form" method="post" enctype="multipart/form-data" action="{{route('business.personel.update', $personel->id)}}" class="form d-flex flex-column flex-lg-row">
            @csrf
            @method('PUT')
            @can('personel.update')
                <!--begin::Aside column-->
                @include('business.personel.edit.setting.parts.col-1')
                <!--end::Aside column-->
                <!--begin::Main column-->
                @include('business.personel.edit.setting.parts.col-2')
                <!--end::Main column-->

            @else
                <div class="card w-100">
                    <div class="card-body">
                        <x-forbidden-component title="Yetkisiz Erişim" message="Personel Bilgierine erişmek için yetkiniz bulunmamaktadır"></x-forbidden-component>
                    </div>
                </div>

            @endcan

        </form>

        @can('personel.update')
            <div class="d-flex justify-content-end flex-row">

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_add_product_submit" onclick="$('#kt_ecommerce_edit_personel_form').submit()" class="btn btn-primary w-100 mt-3">
                <span class="indicator-label">
                    Kaydet
                </span>
                </button>
                <!--end::Button-->
            </div>
        @endcan
    <!--end::Form-->
    </div>
@endsection
@section('scripts')

    <script>

        $(".timeSelector").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

    </script>
@endsection
