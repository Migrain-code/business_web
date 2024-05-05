@extends('business.layouts.master')
@section('title', 'Personel Randevuları')
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
        <a href="{{route('personel.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('personel.appointments')}}"> Randevular </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Randevu Takvimi
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
                <!--begin::Calendar-->
                <div id="kt_calendar_app"></div>
                <!--end::Calendar-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Modal - New Product--><!--begin::Modal - New Product-->
        <div class="modal fade" id="kt_modal_view_event" tabindex="-1" data-bs-focus="false" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Kapat" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>                </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                    <!--begin::Modal body-->
                    <div class="modal-body pt-0 pb-20 px-lg-17">
                        <!--begin::Row-->
                        <div class="d-flex">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-calendar-8 fs-1 text-muted me-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i>                    <!--end::Icon-->

                            <div class="mb-9">
                                <!--begin::Event name-->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-3 fw-bold me-3" data-kt-calendar="event_name"></span> <span class="badge badge-light-success" data-kt-calendar="all_day"></span>
                                </div>
                                <!--end::Event name-->

                                <!--begin::Event description-->
                                <div class="fs-6" data-kt-calendar="event_description"></div>
                                <!--end::Event description-->
                            </div>
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot h-10px w-10px bg-success ms-2 me-7"></span>
                            <!--end::Bullet-->

                            <!--begin::Event start date/time-->
                            <div class="fs-6"><span class="fw-bold">Başlangıç Saati</span> <span data-kt-calendar="event_start_date"></span></div>
                            <!--end::Event start date/time-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="d-flex align-items-center mb-9">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-dot h-10px w-10px bg-danger ms-2 me-7"></span>
                            <!--end::Bullet-->

                            <!--begin::Event end date/time-->
                            <div class="fs-6"><span class="fw-bold">Bitiş Saati</span> <span data-kt-calendar="event_end_date"></span></div>
                            <!--end::Event end date/time-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="d-flex align-items-center">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-user fs-1 text-muted me-5"><span class="path1"></span><span class="path2"></span></i>                    <!--end::Icon-->

                            <!--begin::Event location-->
                            <div class="fs-6" data-kt-calendar="event_location"></div>
                            <!--end::Event location-->
                        </div>
                        <!--end::Row-->
                        <div class="d-flex align-items-center mt-3">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-chart-pie-3 fs-1 text-muted me-5"><span class="path1"></span><span class="path2"></span></i>                    <!--end::Icon-->

                            <!--begin::Event location-->
                            <div class="fs-6" data-kt-calendar="event_status"></div>
                            <!--end::Event location-->
                        </div>
                    </div>
                    <!--end::Modal body-->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/business/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>

    <script>
        var eventCollection = [];
        @foreach($appointments as $appointment)
        var newEvent = {
            id: "{{$appointment->id}}",
            title: "{{$appointment->services->count() > 1 ? $appointment->services->first()->service->subCategory->name." +". $appointment->services->count(): $appointment->services->first()->service->subCategory->name}}",
            start: "{{$appointment->start_time->format('Y-m-d H:i')}}",
            end: "{{$appointment->end_time->format('Y-m-d H:i')}}",
            description: "Toplam Tutar : "+ "{{formatPrice($appointment->calculateTotal())}}",
            className: "fc-event-danger fc-event-solid-warning",
            username: "{{$appointment->customer->name}}",
            status: "{{$appointment->status("text")}}"
        };
        eventCollection.push(newEvent);

        @endforeach

    </script>
    <script src="/business/assets/js/project/calendar/calendar.js"></script>


@endsection
