@extends('business.layouts.master')
@section('title', 'Personel Düzenle')
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
        <a href="{{route('business.personel.index')}}"> Personeller </a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Personel Düzenle
    </li>
@endsection
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content ">
        @include('business.personel.edit.nav')
        <!--begin::Row-->
        @include('business.personel.edit.overview.index')
        <!--end::Row-->
    </div>
    <!--end::Content-->
    @php
        use Illuminate\Support\Carbon;
        $year = now()->year;
        $months = [];
        for ($i = 1; $i <= 12; $i++){
            $month = $year."-".$i. "-01";
            $months[] = Carbon::parse($month)->translatedFormat('F');
        }
    @endphp
@endsection
@section('scripts')
    <script>
        var appointmentData = [
            {!! $personel->appointments->whereIn('status', [1])->count() !!},
            {!! $personel->appointments->whereIn('status', [2, 5, 6])->count() !!},
            {!! $personel->appointments->whereIn('status', [3, 4])->count() !!}
        ];
        var months = @json($months);
        var packageSales = @json($personel->getMonthlyPackageSales());
        var productSales = @json($personel->getMonthlyProductSales());
    </script>
    <!-- DataTables Buttons JS -->
    <script src="/business/assets/js/project/personel-account/overview/project.js"></script>

    <script>

        $(".timeSelector").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        var allChecked = false;
        $("#serviceAllSelect").on('click', function (){
            let btn = $(this);
            if (!allChecked) {
                $('.serviceChecks').prop('checked', true);
                allChecked = true;
                btn.text("Seçimi Kaldır");
            } else{
                $('.serviceChecks').prop('checked', false);
                allChecked = false;
                btn.text("Tümünü Seç");
            }
        });
    </script>
@endsection
