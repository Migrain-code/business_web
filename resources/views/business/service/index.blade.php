@extends('business.layouts.master')
@section('title', 'Hizmetler')
@section('styles')
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
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Hizmetler
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                class="path1"></span><span class="path2"></span></i> <input
                            type="text" data-kt-sale-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13"
                            placeholder="Hizmetlerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.service.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Eklenme Tarihi</th>
                        <th class="min-w-125px">Kategori</th>
                        <th class="min-w-125px">Hizmet Adı</th>
                        <th class="min-w-125px">Sık Kullanılan</th>
                        <th class="min-w-125px">Hizmet Fiyatı</th>
                        <th class="min-w-125px">Tür</th>
                        <th class="text-end min-w-70px">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->    </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        @include('business.service.parts.add-service')
    </div>
@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/service/listing/listing.js"></script>
    <script src="/business/assets/js/project/service/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.service.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'created_at'},
            {data: 'category'},
            {data: 'sub_category'},
            {data: 'is_featured'},
            {data: 'price'},
            {data: 'type'},
            {data: 'action'}
        ];
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
