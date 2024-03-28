@extends('business.layouts.master')
@section('title', 'Randevu Detayı')
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
        <a href="{{route('business.appointment.index')}}"> Randevular </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Randevu Detayı
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">

        <!--begin::Order details page-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
            <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                           href="#kt_ecommerce_sales_order_summary">Randevu Bilgileri</a>
                    </li>
                    <!--end:::Tab item-->

                </ul>
                <!--end:::Tabs-->

                <!--begin::Button-->
                <a href="{{route('business.appointment.index')}}" class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                    <i class="ki-duotone ki-left fs-2"></i> </a>
                <!--end::Button-->

                <!--begin::Button-->
                <a href="{{route('business.appointmentCreate.index')}}" class="btn btn-primary btn-sm">Randevu Oluştur</a>
                <!--end::Button-->
            </div>
            <!--begin::Order summary-->
            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                <!--begin::Order details-->
                <div class="card card-flush py-4 flex-row-fluid">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center">
                        <div class="card-title">
                            <h2>Randevu Detayı (#{{$appointment->id}})</h2>
                        </div>
                        <div class="btn-wrapper">
                            <button type="button" class="btn btn-lg btn-icon btn-icon-primary btn-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-3 svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">İşlemler</div>
                                </div>
                                <!--end::Heading-->
                                @if($appointment->status == 0)
                                    <form method="post" action="{{route('business.appointment.update', $appointment->id)}}" id="approveForm">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" onclick="$('#approveForm').submit()" class="menu-link px-3">Onayla</a>
                                    </div>
                                    <!--end::Menu item-->
                                @endif
                                <!--begin::Menu item-->
                                @if($appointment->status != 3)
                                    <form method="post" action="{{route('business.appointment.destroy', $appointment->id)}}" id="cancelForm">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" onclick="$('#cancelForm').submit()" class="menu-link flex-stack px-3">İptal Et
                                            <i class="fas fa-exclamation-circle ms-2 fs-7"
                                               data-bs-toggle="tooltip"
                                              title="Specify a target name for future usage and reference" data-kt-initialized="1">

                                            </i>
                                        </a>
                                    </div>
                                @endif
                                <!--end::Menu item-->
                                @if($appointment->status != 0)
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">

                                        <a href="{{route('business.appointment.edit', $appointment->id)}}" class="menu-link flex-stack px-3">Tamamla
                                            <i class="fas fa-check-circle ms-2 fs-7">
                                            </i>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                @endif
                            </div>
                        </div>

                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-calendar-8 fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            Randevu Tarihi
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{\Illuminate\Support\Carbon::parse($appointment->start_time)->format('d.m.Y H:i:s')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-electronic-clock fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            İşlem Süresi
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{\Illuminate\Support\Carbon::parse($appointment->end_time)->diffInMinutes($appointment->start_time)}} .DK
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-calendar fs-2 me-2"><span class="path1"></span><span
                                                    class="path2"></span></i> Durumu
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{!! $appointment->status("html") !!}</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Order details-->

                <!--begin::Customer details-->
                <div class="card card-flush py-4  flex-row-fluid">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Müşteri Detayı</h2>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-profile-circle fs-2 me-2"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i> Müşteri Adı
                                        </div>
                                    </td>

                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                <a href="{{route('business.customer.edit', $appointment->customer_id)}}">
                                                    <div class="symbol-label">
                                                        <img src="{{image($appointment->customer->image)}}"
                                                             alt="{{$appointment->customer->name}}" class="w-100">
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->

                                            <!--begin::Name-->
                                            <a href="{{route('business.customer.edit', $appointment->customer_id)}}"
                                               class="text-gray-600 text-hover-primary">
                                                {{$appointment->customer->name}}
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-sms fs-2 me-2"><span class="path1"></span><span
                                                    class="path2"></span></i> E-posta
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <a href="{{route('business.customer.edit', $appointment->customer->id)}}"
                                           class="text-gray-600 text-hover-primary">
                                           {{$appointment->customer->email}} </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-phone fs-2 me-2"><span class="path1"></span><span
                                                    class="path2"></span></i> Telefon
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        @php
                                            $formattedPhone = formatPhone($appointment->customer->phone);
                                        @endphp
                                        <a href="tel: {{$formattedPhone}}">{{$formattedPhone}}</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Customer details-->
                <!--begin::Documents-->
                <div class="card card-flush py-4  flex-row-fluid">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Diğer</h2>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-devices fs-2 me-2">
                                                <span class="path1"></span>
                                                <span
                                                    class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span></i>
                                            Kupon Kullanımı
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Müşteri Bir Kupon Kodu Kullanmışsa Kullandığı kodu bu alanda görüntülenir">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                       @if(isset($appointment->campaign_id))
                                           <a href="">{{$appointment->campaign->getTitle()}}</a>
                                        @else
                                           Yok
                                       @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-note fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            Not
                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                  title="Bu randevuya bırakılan notlar">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{$appointment->note}}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Documents-->
            </div>
            <!--end::Order summary-->

            <!--begin::Tab content-->
            <div class="tab-content">
                @include('business.appointment.edit.parts.tab-1')
                @include('business.appointment.edit.parts.tab-2')


            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Order details page-->
    </div>
    @include('business.appointment.edit.modals.add-service')
@endsection
@section('scripts')

@endsection
