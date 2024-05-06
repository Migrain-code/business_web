@extends('business.layouts.master')
@section('title', 'Destek Merkezi | Dökümanlar')
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
        <a href="{{route('business.support-center.index')}}">Destek Merkezi</a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Döküman Klasörleri
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        @include('business.support-center.layouts.header')
        <!--begin::Home card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-8">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-filemanager-table-filter="search"
                               class="form-control form-control-solid w-250px ps-15"
                               placeholder="Klasörlerde Ara">
                    </div>
                    <!--end::Search-->
                </div>

            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Table-->
                <table id="datatable" data-kt-filemanager-table="folders" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-10px pe-2">
                            #
                        </th>
                        <th class="min-w-250px">Klasör Adı</th>
                        <th class="min-w-10px">Boyut</th>
                        <th class="min-w-125px">Son Düzenleme</th>
                        <th class="w-125px"></th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse($folders as $folder)
                            <tr>
                                <td>
                                    1
                                </td>
                                <td data-order="account">
                                    <div class="d-flex align-items-center">
                                        <span class="icon-wrapper">
                                            <i class="ki-duotone ki-folder fs-2x text-primary me-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <a href="{{route('business.support.document.folder', $folder->id)}}"
                                           class="text-gray-800 text-hover-primary">{{$folder->name}}</a>
                                    </div>
                                </td>
                                <td>
                                    {{$folder->size}}
                                </td>
                                <td>
                                    {{$folder->updated_at->format('d.m.Y')}}
                                </td>
                                <td class="text-end" data-kt-filemanager-table="action_dropdown">
                                    <div class="d-flex justify-content-end">

                                        <!--begin::More-->
                                        <div class="ms-2">
                                            <button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                <i class="ki-duotone ki-dots-square fs-5 m-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                                    </button>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{route('business.support.document.folder', $folder->id)}}" class="menu-link px-3">
                                                        Aç
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-kt-filemanager-table="rename">
                                                        Klasörü İndir
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->                                    <!--end::More-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty

                        @endforelse


                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
@endsection
@section('scripts')
            <script src="/business/assets/js/project/document/listing.js"></script>

@endsection
