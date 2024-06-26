@extends('business.layouts.master')
@section('title', 'Oda Düzenle')
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
        <a href="{{route('business.room.index')}}"> Salonlar </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Salon Düzenle
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
                           href="#kt_ecommerce_customer_general">Bilgileri</a>
                    </li>
                    <!--end:::Tab item-->

                </ul>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    @include('business.room.detail.component.tabs.edit')

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
        let updateUrl = "{{route('business.room.update', $room->id)}}";
    </script>

    <script src="/business/assets/js/project/room/details/update-profile.js"></script>
    <script>
        $('#increaseTypeSelect').on('change', function(){
            var selectedId = $(this).val();
            if(selectedId == 0){
                $('#increaseTypeText').text("Fiyat Kaç TL Arttırılacak");
                $('#increaseTypeNote').text("Hizmet Bedelinin üzerine eklenecek tutarı giriniz");
                $('#increaseTypeInput').attr('placeholder', "Örn. 10 TL");
            } else{
                $('#increaseTypeText').text("Fiyat Yüzde Kaç Arttırılacak");
                $('#increaseTypeNote').text("Hizmet Bedelinin üzerine eklenecek yüzdelik oranı giriniz");

                $('#increaseTypeInput').attr('placeholder', "Örn. 10 %");

            }
        });
    </script>

@endsection
