@extends('business.layouts.master')
@section('title', 'Talep Detayı')
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
        <a href="{{route('business.appointment-request.index')}}"> Talepler </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Talep Detayı
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                           href="#kt_ecommerce_customer_general">Güncelle</a>
                    </li>
                    <!--end:::Tab item--><!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                           href="#appointment_request_form">Form Detayı</a>
                    </li>
                    <!--end:::Tab item-->

                </ul>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    @include('business.appointment-request.detail.component.tabs.edit')
                    @include('business.appointment-request.detail.component.tabs.qustions')
                    {{--
                        @include('business.branche.detail.component.tabs.overview')
                    --}}
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
        let updateUrl = "{{route('business.appointment-request.update', $appointmentRequest->id)}}";
    </script>

    <script src="/business/assets/js/project/appointment-request/details/update-profile.js"></script>
    <script>

        $('[name="status"]').on('change', function (){
            let val = $(this).val();
            var callDateInput = document.getElementById('callDateInput');
            if (val === "3") {
                callDateInput.classList.add('d-block');
                callDateInput.classList.remove('d-none');
            } else {
                callDateInput.classList.remove('d-block');
                callDateInput.classList.add('d-none');
            }
        })
    </script>
@endsection
