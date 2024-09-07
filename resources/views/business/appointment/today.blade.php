@extends('business.layouts.master')
@section('title', 'Bugünkü Randevuları')
@section('styles')
<style>
    .draggableTodayAppointment {
        cursor: move; /* Sürüklenebilir olduğunu belirtmek için */
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
@section('toolbar')
    <button class="btn btn-primary" onclick="openFullScreen()">Takvimi Büyüt</button>
@endsection
@section('content')
    @php
        $selectedDate = request()['selectedDate'];
    @endphp
    <div class="app-content " id="appointmentCalendar">
        <div class="card ">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    Bugünkü Randevular ({{isset($selectedDate) ? \Illuminate\Support\Carbon::parse($selectedDate)->format('d.m.Y') : now()->format('d.m.Y')}})
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <input type="text" class="datePickerInput" name="selectedDate" placeholder="Tarih Seçiniz" value="{{isset($selectedDate) ? $selectedDate : now()->toDateString()}}">

                    </div>
                        <!--end::Menu-->
                        <!--end::Export-->
                        <!--end::Add customer-->
                </div>
                    <!--end::Toolbar-->


            </div>
                <!--end::Card toolbar-->

            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body" >
                <div class="scroll-x  overflow-y-hidden" style="transform: rotateX(180deg);">

                    <div class="row" style="width: {{$personels->count() * 250}}px; transform: rotateX(-180deg);padding-top: 10px">
                        @foreach($personels as $personel)
                            <div class="w-250px draggableTodayAppointment">
                                <!--begin::Personel Widget 5-->
                                <div class="card  bg-gray-100">
                                    <!--begin::Header-->
                                    <div class="card-header d-flex align-items-center justify-content-center flex-column border-0 mt-4">
                                        <img src="{{image($personel->image)}}" class="w-60px h-60px rounded-circle" style="object-fit: cover"/>

                                        <h3 class="mt-2 ">
                                            <span class="fw-bold mb-1 text-dark fs-4">{{$personel->name}}</span>
                                        </h3>
                                        {{-- <span class="text-muted fw-semibold fs-6 mb-3">{{$personel->todayAppointments->count()}} Randevu</span>
 --}}
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
                                    @php

                                        if (isset($selectedDate)){
                                            $appointments = $personel->appointments()->whereDate('start_time', $selectedDate)->orderBy('start_time', 'asc')->get();
                                        } else{
                                            $appointments = $personel->todayAppointments;
                                        }
                                    @endphp
                                    <!--end::Separator-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-5" style="padding: 1rem 1rem;">
                                        <!--begin::Timeline-->
                                        <div class="timeline-label">
                                            @forelse($appointments as $appointment)
                                                <!--begin::Randevu Item-->
                                                <div class="timeline-item">
                                                    <!--begin::Label-->
                                                    <a class="timeline-label fw-bold text-gray-800 fs-6" href="{{route('business.appointment.show', $appointment->appointment_id)}}">
                                                        <span class="cursor-pointer" data-bs-toggle="tooltip" title="Başlangıç Saati"> {{$appointment->start_time->format('H:i')}}</span>
                                                        <span class="cursor-pointer text-gray-700 endTime" data-end-time="{{$appointment->end_time->format('H:i')}}" data-bs-toggle="tooltip" title="Bitiş Saati"> {{$appointment->end_time->format('H:i')}}</span>

                                                    </a>
                                                    <!--end::Label-->
                                                    <!--begin::Badge-->
                                                    <div class="timeline-badge cursor-pointer" data-bs-toggle="tooltip" title="{{$appointment->status("text")}}">
                                                        <i class="fa fa-genderless text-{{$appointment->status("color_code")}} fs-1"></i>
                                                    </div>
                                                    <!--end::Badge-->
                                                    <!--begin::Content-->
                                                    <div class="timeline-content d-flex align-items-center">

                                                        <div class="col-12 ms-2">
                                                            <div class="fw-bold text-gray-700">{{$appointment->appointment->customer->name}}</div>
                                                            <div class="fw-bold">{{$appointment->service->subCategory->name}} </div>

                                                            @if(isset($appointment->appointment->room_id) && $appointment->appointment->room_id > 0)
                                                                <div class="fw-semibold" style="color: {{$appointment->appointment->room->color}}">{{$appointment->appointment->room->name}}</div>

                                                            @endif
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


            </div>
            <!--end::Card body-->
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        setCloseClockStatus = false;
        @if(isset($selectedDate))
            @if($selectedDate == now()->toDateString())
                @if($business->is_past_appointment == 0)
                    setCloseClockStatus = true;  // Saatler kapalı
                @else
                    setCloseClockStatus = false; // Saatler açık
                @endif
            @else
                setCloseClockStatus = false; // Bugünden farklı bir tarih ise kapatmasın
            @endif
        @else
            @if($business->is_past_appointment == 0)
                setCloseClockStatus = true;  // Saatler kapalı
            @else
                setCloseClockStatus = false; // Saatler açık
            @endif
        @endif


    </script>
    <script src="/business/assets/js/project/appointment/today.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.innerWidth >= 768) {
                // SortableJS ile draggableTodayAppointment sınıfına sahip öğeleri sürüklenebilir hale getirin
                const container = document.querySelectorAll('.draggableTodayAppointment');
                container.forEach((col) => {
                    new Sortable(col.parentNode, {
                        group: 'shared', // Aynı grup ismine sahip öğeler arasında sürükleyip bırakabilirsiniz
                        animation: 150,
                        onEnd: function (evt) {
                            console.log(`Item ${evt.item.textContent.trim()} moved to position ${evt.newIndex + 1}`);
                        }
                    });
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <script>
        $(document).ready(function(){
            // Initialize date picker
            $('.datePickerInput').flatpickr({
                altInput: true,
                altFormat: "d F, Y", // Format for the displayed date
                dateFormat: "Y-m-d", // Format for the actual input value
                enableTime: false, // Disable time picker
                locale: 'tr', // Turkish localization
                onChange: function(selectedDates, dateStr, instance) {
                    window.location.href = "/isletme/randevular?selectedDate="+dateStr;
                },
            });

        });
    </script>
@endsection
