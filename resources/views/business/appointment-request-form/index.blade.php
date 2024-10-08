@extends('business.layouts.master')
@section('title', 'Talep Formlarınız')
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
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.dep.index')}}"> Talep Formlarınız </a>
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
                            type="text" data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13"
                            placeholder="Formlarda Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.appointment-request-form.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            #
                        </th>
                        <th class="min-w-125px">Talep Form Başlığı</th>
                        <th class="min-w-125px">Bu Formu Göster</th>
                        <th class="min-w-125px">Hizmet Sayısı</th>
                        <th class="min-w-125px">Oluşturma Tarihi</th>
                        <th class="min-w-70px">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        <!--begin::Modals-->
        @can('appointmentRequestForm.create')
        <!--begin::Modal - Customers - Add-->
        @include('business.appointment-request-form.parts.add-customer')
        @endcan
    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/request-form/listing/listing.js"></script>
    <script src="/business/assets/js/project/request-form/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.request-form.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'id'},
            {data: 'name'},
            {data: 'is_default'},
            {data: 'serviceCount'},
            {data: 'created_at'},
            {data: 'action'}
        ];
    </script>
    <script>
        $(document).on('change', '.custom-ajax-switch', function () {
            let route = $(this).data('route')
            $.ajax({
                url: route,
                type: "GET",
                success: function (res) {
                    Swal.fire({
                        icon: res.status,
                        text: res.text ? res.text : res.message,
                        confirmButtonText: 'Tamam'
                    });
                    if(res.status == "success"){
                        if ($.fn.DataTable.isDataTable('#datatable')) {
                            $('#datatable').DataTable().ajax.reload();
                        }
                    }
                }
            });
        })
    </script>
@endsection
