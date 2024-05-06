@extends('business.layouts.master')
@section('title', 'İşletme Randevuları')
@section('styles')
    <link href="/business/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        .fc-timegrid-event-harness-inset .fc-timegrid-event, .fc-timegrid-event.fc-event-mirror, .fc-timegrid-more-link {
            box-shadow: 0 0 0 1px #fff;
            box-shadow: 0 0 0 1px var(--fc-page-bg-color, #fff);
            min-height: 25px;
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('personel.home')}}"> Gösterge Paneli </a>
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
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Bugünkü Randevular
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="card ">
            <!--begin::Card header-->
            <div class="card-header">
                <h2 class="card-title fw-bold">
                    Randevu Takvimi
                </h2>

            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <div class="row">
                    @foreach($personels as $personel)
                        <div class="col-12 col-lg-4 mb-3">
                            <!--begin::Personel Widget 5-->
                            <div class="card  bg-gray-100">
                                <!--begin::Header-->
                                <div class="card-header d-flex align-items-center justify-content-center flex-column border-0 mt-4">
                                    <img src="{{image($personel->image)}}" class="w-50px h-50px rounded-circle"/>

                                    <h3 class="mt-2">
                                        <span class="fw-bold mb-1 text-dark">{{$personel->name}}</span>
                                    </h3>
                                    <span class="text-muted fw-semibold fs-6 mb-3">{{$personel->todayAppointments->count()}} Randevu</span>

                                    {{--
                                        <div class="card-toolbar">
                                        <!--begin::Menu-->
                                        <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fa fa-print"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </div>
                                    --}}
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed"></div>
                                <!--end::Separator-->
                                <!--begin::Body-->
                                <div class="card-body pt-5">
                                    <!--begin::Timeline-->
                                    <div class="timeline-label">
                                        @forelse($personel->todayAppointments as $appointment)
                                            <!--begin::Randevu Item-->
                                            <div class="timeline-item">
                                                <!--begin::Label-->
                                                <div class="timeline-label fw-bold text-gray-800 fs-6">
                                                   <span class="cursor-pointer" data-bs-toggle="tooltip" title="Başlangıç Saati"> {{$appointment->start_time->format('H:i')}}</span>
                                                   <span class="cursor-pointer text-gray-700" data-bs-toggle="tooltip" title="Bitiş Saati"> {{$appointment->end_time->format('H:i')}}</span>

                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Badge-->
                                                <div class="timeline-badge cursor-pointer" data-bs-toggle="tooltip" title="{{$appointment->status("text")}}">
                                                    <i class="fa fa-genderless text-{{$appointment->status("color_code")}} fs-1"></i>
                                                </div>
                                                <!--end::Badge-->
                                                <!--begin::Content-->
                                                <div class="timeline-content d-flex align-items-center">
                                                    <div class="col ms-3" style="max-width: 55px">
                                                        <img src="{{image($appointment->appointment->customer->image)}}" class="w-50px h-50px rounded-circle"/>
                                                    </div>
                                                    <div class="col-8 ms-2">
                                                        <div class="fw-bold text-muted">{{$appointment->appointment->customer->name}}</div>
                                                        <div class="fw-bold">{{$appointment->service->subCategory->name}}</div>
                                                    </div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Item-->
                                        @empty
                                            @include('business.layouts.components.alerts.empty-alert')
                                        @endforelse

                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end: Personel Widget 5-->
                        </div>
                    @endforeach

                </div>

            </div>
            <!--end::Card body-->
        </div>

    </div>
@endsection
@section('scripts')


@endsection
