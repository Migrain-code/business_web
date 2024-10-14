@extends('business.layouts.master')
@section('title', 'Şubeler')
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
        <a href="{{route('business.branche.index')}}"> Şubeler </a>
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
                            placeholder="Şubelerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.branche.parts.toolbar')
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
                        <th class="min-w-125px">Şube Adı</th>
                        <th class="min-w-125px">Yetkili</th>
                        <th class="min-w-125px">Yasak</th>
                        <th class="min-w-125px">Randevu Sayısı</th>
                        <th class="min-w-125px">Kayıt Tarihi</th>
                        <th class="min-w-70px">İşlemler</th>
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
        @can('branche.create')
         @include('business.branche.parts.add-customer')
        @endcan
    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/branche/listing/listing.js"></script>
    <script src="/business/assets/js/project/branche/listing/add.js"></script>

    <script>
        let DATA_URL = "{{route('business.branche.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'id'},
            {data: 'branch_name'},
            {data: 'official'},
            {data: 'status'},
            {data: 'appointmentCount'},
            {data: 'created_at'},
            {data: 'action'}
        ];
    </script>
    <script>
        $(document).on('click', '.copyBranche', function () {
            let id = $(this).data('object-id')

            Swal.fire({
                title: 'Şubeyi Kopyalamak İstediğinize Eminmisiniz',
                html: 'Şubeyi kopyaladığınızda. Şubenin: <ul style="margin-top: 10px;margin-bottom: 10px;">' +
                    '<li>Genel Bilgileri</li>' +
                    '<li>Ürünleri</li>' +
                    '<li>Promosyon Bilgileri</li>' +
                    '<li>Randevu Ayarları</li>' +
                    '</ul> Yeni Şubeye Aktarılır.' ,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Hayır, İptal Et",
                confirmButtonText: "Evet, Kopyala!",
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/isletme/branche/'+id+'/copy',
                        type: "POST",
                        data: {
                            "_token": csrf_token,
                        },
                        dataType: "JSON",
                        success: function (res) {
                            if (res.status == "success"){
                                Swal.fire({
                                    title:  res.message,
                                    icon: res.status,
                                    confirmButtonText: 'Tamam'
                                })
                                if ($('#datatable').length > 0 && $.fn.DataTable.isDataTable('#datatable')) {
                                    $('#datatable').DataTable().ajax.reload();
                                }
                            }
                            else {
                                Swal.fire({
                                    title: "Uyarı",
                                    icon: res.status,
                                    text: res.message,
                                    confirmButtonText: 'Tamam'
                                })
                            }

                        }
                    });
                }
            });

        });

    </script>
@endsection
