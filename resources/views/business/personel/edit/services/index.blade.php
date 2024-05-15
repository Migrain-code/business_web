@extends('business.layouts.master')
@section('title', 'Personel Hizmetleri')
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
        <form id="kt_ecommerce_edit_personel_form" method="post" action="{{route('business.personel.services.update', $personel->id)}}" class="form d-flex flex-column flex-lg-row">
            @csrf

            <!--begin::Service column-->
            @include('business.personel.edit.services.parts.col-3')
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
    <script>
        function addPersonelCustomPrice(serviceId){

            let priceElementValue = $(`#prices${serviceId}`).val();
            var formData = new FormData();
            formData.append("_token", csrf_token);
            formData.append("business_service_id", serviceId);
            formData.append("price", priceElementValue);
            $.ajax({
                url: '/isletme/personel/'+'{{$personel->id}}'+'/add-custom-price',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        text: res.message,
                        icon: res.status,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                },
                error: function (xhr) {
                    var errorMessage = "<ul>";
                    xhr.responseJSON.errors.forEach(function (error) {
                        errorMessage += "<li>" + error + "</li>";
                    });
                    errorMessage += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        html: errorMessage,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        }
        function deletePersonelCustomPrice(serviceId){

            let priceElement = $(`#prices${serviceId}`);
            var formData = new FormData();
            formData.append("_token", csrf_token);
            formData.append("business_service_id", serviceId);
            formData.append("price", priceElement.val());
            $.ajax({
                url: '/isletme/personel/'+'{{$personel->id}}'+'/delete-custom-price',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function (res) {
                    if(res.status === "success"){
                        priceElement.val(res.price);
                    }
                    Swal.fire({
                        text: res.message,
                        icon: res.status,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });

                },
                error: function (xhr) {
                    var errorMessage = "<ul>";
                    xhr.responseJSON.errors.forEach(function (error) {
                        errorMessage += "<li>" + error + "</li>";
                    });
                    errorMessage += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        html: errorMessage,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        }
    </script>
@endsection
