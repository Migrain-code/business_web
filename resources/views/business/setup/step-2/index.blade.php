@extends('business.layouts.master')
@section('title', 'İşletme Kurulumu 2. Adım')
@section('styles')
    <style>
        #kt_forms_widget_1_editor {
            height: 200px; /* Yüksekliği 200 piksel olarak ayarla */
        }
        @if(isset($business->logo))
         .image-input .image-input-wrapper {
            background-image: url('{{image($business->logo)}}');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('{{image($business->logo)}}');
        }
        @else
         .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
        }
        @endif


    </style>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10" id="kt_create_account_stepper">
            @include('business.setup.parts.aside-2')

            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                <!--begin::Form-->
                <form class="card-body py-20 w-100 px-9" novalidate="novalidate" id="kt_create_account_form">
                    @include('business.setup.step-2.parts.step-1')
                    @include('business.setup.step-2.parts.step-2')
                    @include('business.setup.step-2.parts.step-3')
                    @include('business.setup.step-2.parts.step-4')
                    <!--begin::Actions-->
                    <div class="d-flex flex-stack pt-10">
                        <!--begin::Wrapper-->
                        <div class="mr-2">
                            <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                <i class="ki-duotone ki-arrow-left fs-4 me-1"><span class="path1"></span><span class="path2"></span></i> Önceki
                            </button>
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Wrapper-->
                        <div>
                            <button type="button" class="btn btn-lg btn-primary me-3" id="setupCompeteBtn" data-kt-stepper-action="submit">
                        <span class="indicator-label">
                            Kurulumu Tamamla
                            <i class="ki-duotone ki-arrow-right fs-3 ms-2 me-0"><span class="path1"></span><span class="path2"></span></i>                        </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>

                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">
                                Sonraki
                                <i class="ki-duotone ki-arrow-right fs-4 ms-1 me-0"><span class="path1"></span><span class="path2"></span></i>                    </button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
        <div class="card mt-5">
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
                        <th class="min-w-125px">Hizmet Süresi</th>
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
        @include('business.setup.step-2.modals.add-service')
        @include('business.setup.step-2.modals.add-personel')
    </div>
@endsection
@section('scripts')
    <script src="/business/assets/js/project/service/listing/listing.js"></script>
    <script src="/business/assets/js/project/setup/setup-2.js"></script>
    <script>
        let DATA_URL = "{{route('business.service.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'created_at'},
            {data: 'category'},
            {data: 'sub_category'},
            {data: 'time'},
            {data: 'price'},
            {data: 'type'},
            {data: 'action'}
        ];
    </script>
    <script>
        $(".timeSelector").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    </script>
    <script>
        var myDropzone = new Dropzone("#drop_zone_area", {
            url: '/isletme/gallery', // Set the url for your upload script location
            paramName: "image", // The name that will be used to transfer the file
            maxFiles: 5,
            maxFilesize: 3, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': csrf_token // CSRF token'ini ekleyin
            },
            success: function(file, response) {
                Swal.fire({
                    icon: response.status,
                    title: response.message,
                    confirmButtonText: 'Tamam',
                });
            },
        });
    </script>

@endsection
