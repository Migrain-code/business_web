@extends('business.layouts.master')
@section('title', 'Yetkili Detayı')
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
        <a href="{{route('business.business-official.index')}}"> Yetkililer </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Yetkili Detayı
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            @include('business.official.detail.component.profile')
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
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                           href="#kt_ecommerce_customer_overview">Yetkileri</a>
                    </li>
                </ul>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    @include('business.official.detail.component.tabs.edit')
                    @include('business.official.detail.component.tabs.permission')

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
        let updateUrl = "{{route('business.business-official.update', $official->id)}}";
    </script>
    <script>
        var allChecked = false;
        $("#serviceAllSelect").on('click', function (){
            let btn = $(this);
            if (!allChecked) {
                $('.serviceChecks').prop('checked', true);
                $('.categorySwitch').prop('checked', true);

                allChecked = true;
                btn.text("Seçimi Kaldır");
            } else{
                $('.serviceChecks').prop('checked', false);
                $('.categorySwitch').prop('checked', false);

                allChecked = false;
                btn.text("Tümünü Seç");
            }
        });
        $('.categorySwitch').change(function() {

            var targetClass = $(this).data('target');
            var isChecked = $(this).is(':checked');
            $('.' + targetClass).prop('checked', isChecked);
        });
        $(function (){
            var productSwitches = $('.productSwitch');

            $.each(productSwitches, function (index, item) {

                var targetClass = $(item).data('category');
                var isChecked = $(item).is(':checked');
                $('.' + targetClass).prop('checked', isChecked);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#permissionIdSelect').on('change', function () {
                // Seçilen grubun ID'sini alıyoruz
                let permissionId = $(this).val();

                // Eğer alınan ID geçerli ise, ilgili kartın içeriğini güncelliyoruz
                if (permissionId) {
                    // Kartı ID'sine göre seçiyoruz
                    let card = $('#permissionGroup' + permissionId);
                    card.find('.some-class').text('Güncellenmiş içerik burada: ' + permissionId);

                    // Kartın olduğu yere kaydırma yapıyoruz
                    $('html, body').animate({
                        scrollTop: card.offset().top - 100
                    }, 1000);
                }
            });
        });
    </script>
    <script src="/business/assets/js/project/official/details/update-profile.js"></script>
@endsection
