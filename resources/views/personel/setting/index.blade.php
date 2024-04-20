@extends('personel.layouts.master')
@section('title', 'Kullanıcı Bilgilerim')
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
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Kullanıcı Bilgilerim
    </li>
    <!--end::Item-->

@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
    <!--begin::Form-->
        <form id="kt_ecommerce_edit_personel_form" method="post" enctype="multipart/form-data" action="{{route('personel.setting.update')}}" class="form d-flex flex-column flex-lg-row">
            @csrf
            <!--begin::Aside column-->
            @include('personel.setting.parts.col-1')
            <!--end::Aside column-->
            <!--begin::Main column-->
            @include('personel.setting.parts.col-2')
            <!--end::Main column-->
            <!--begin::Service column-->
            @include('personel.setting.parts.col-3')
            <!--end::Service column-->
        </form>
        <div class="d-flex justify-content-end flex-row">

            <!--begin::Button-->
            <button type="submit" id="kt_ecommerce_add_product_submit" onclick="$('#kt_ecommerce_edit_personel_form').submit()" class="btn btn-primary w-100 mt-3">
                        <span class="indicator-label">
                            Kaydet
                        </span>
            </button>
            <!--end::Button-->
        </div>
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

        var allChecked = false;
        $("#serviceAllSelect").on('click', function (){
            let btn = $(this);
            if (!allChecked) {
                $('.serviceChecks').prop('checked', true);
                allChecked = true;
                btn.text("Seçimi Kaldır");
            } else{
                $('.serviceChecks').prop('checked', false);
                allChecked = false;
                btn.text("Tümünü Seç");
            }
        });
    </script>
@endsection
