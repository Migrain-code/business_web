@extends('business.layouts.master')
@section('title', 'Gelmeyen Müşteriler')
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
        <a href="{{route('business.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.customer.index')}}"> Müşteriler </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Gelmeyen Müşteriler
    </li>
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
                            placeholder="Müşterilerde Ara">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.absent.parts.toolbar')
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                       data-kt-check-target="#kt_customers_table .form-check-input"
                                       value="1">
                            </div>
                        </th>
                        <th class="min-w-125px">Müşteri Adı</th>
                        <th class="min-w-125px">Telefon Numarası</th>
                        <th class="min-w-125px">Son Randevu Tarihi</th>
                        <th class="min-w-125px">Randevu Sayısı</th>
                        <th class="min-w-125px">Kayıt Tarihi</th>
                        <th class="text-center min-w-70px">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($customerList as $customer)
                            <tr>
                                <td>#</td>
                                <td>{{createName(route('business.customer.edit', $customer->id), $customer->name)}}</td>
                                <td>{{formatPhone($customer->phone)}}</td>
                                <td>{{$customer->appointments()->latest()->first()->start_time->format('d.m.Y H:i')}}</td>
                                <td>{{$customer->appointments->count()}}</td>
                                <td>{{$customer->created_at}}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" href="tel: {{formatPhone($customer->phone)}}">
                                        <i class="fa fa-phone"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        <!--begin::Modals-->
        <!--begin::Modal - Customers - Add-->
        @include('business.customer.parts.add-customer')

    </div>

@endsection
@section('scripts')
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/absent/listing.js"></script>
    <script>
        $('#dateSelect').on('change', function (){
            $('#listForm').submit();
        });
    </script>
@endsection
