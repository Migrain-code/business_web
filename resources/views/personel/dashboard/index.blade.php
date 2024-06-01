@extends('personel.layouts.master')
@section('title', 'Hesabım')
@section('styles')
    <style>
        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        @media screen and (max-width:500px) {
            .miniSummaryContent{
                display: none !important;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-wrapper {
            width: 100%;
        }

        .ts-dropdown [data-selectable] .highlight {
            background: rgb(129 129 129);
            border-radius: 14px;
            padding: 10px;
        }

        .ts-wrapper.single .ts-control, .ts-wrapper.single .ts-control input {
            background-color: #f5f8fa;
            border: none;
            padding: 13px;
            cursor: pointer;
            border-radius: 7px;
            font-size: 14.3px;
            font-family: 'Inter';
        }

        .ts-wrapper.single .ts-control, .ts-wrapper.single .ts-control input::placeholder {
            color: var(--kt-input-solid-placeholder-color);
            font-weight: 900;
        }

        .ts-control, .ts-wrapper.single.input-active .ts-control {
            background: #f5f8fa;
            cursor: text;
        }

        .header {
            background: transparent;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            display: block;
        }

        .ts-dropdown.plugin-optgroup_columns .ts-dropdown-content {
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 1360px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl {
                max-width: 1200px;
            }
        }

        .feather-arrow-right:before {
            content: "\e912";
            margin-right: 5px !important;
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       <a href="{{route('personel.home')}}"> Hesabım </a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        @include('personel.layouts.menu.nav')
        <!--begin::Row-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade " id="kt_ecommerce_personel_overview" role="tabpanel">
                @include('personel.dashboard.parts.tab-2')

            </div>
            <div class="tab-pane fade show active" id="kt_ecommerce_personel_appointment" role="tabpanel">
                @include('personel.dashboard.parts.calendar')
            </div>
        </div>
        <!--end::Row-->
        @include('personel.appointment.modals.add-customer')
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
    <script>
        var appointmentCreateRoute = '{{route('personel.appointmentCreate.index')}}'
        $(document).ready(function (){
            var targetNavItem = document.querySelector('.clickedDate.active');

            var targetNavItemLeft = targetNavItem.offsetLeft;

            document.querySelector('.scrollable-container').scrollLeft = targetNavItemLeft;
            fetchAppointment('{{now()->format('Y-m-d')}}')
        });
        $('.clickedDate').on('click', function () {
            var date = $(this).data('date');
            fetchAppointment(date);
        });
        $('.appointmentTab').on('click', function (){
            var targetNavItem = document.querySelector('.clickedDate.active');

            var targetNavItemLeft = targetNavItem.offsetLeft;

            document.querySelector('.scrollable-container').scrollLeft = targetNavItemLeft;
           fetchAppointment('{{now()->format('Y-m-d')}}')
        });

        $('.scrollBottomButton').on('click', function (){
            document.querySelector('#clockContainer').scrollTop+= 20;
        });
        $('.scrollBottomButton').on('mouseenter', function (){
            // Mouse üzerinde duran süre boyunca içeriği kaydır
            scrollInterval = setInterval(function() {
                document.querySelector('#clockContainer').scrollTop += 20;
            }, 100); // 100 milisaniyede bir kaydırma yapar
        }).on('mouseleave', function() {
            // Mouse elementin dışına çıktığında kaydırmayı durdur
            clearInterval(scrollInterval);
        });

        function fetchAppointment(date){
            document.getElementById('loader').style.display = 'block';
            var container = document.getElementById('clockContainer');
            container.innerHTML="<div></div>";
            $.ajax({
                url: '/personel/today/appointment',
                type: "GET",
                data: {
                    'appointment_date': date,
                },
                dataType: "JSON",
                success: function (response) {

                    var items = "";
                    if(response.length > 0){
                        $.each(response, function (index, item) {

                            if(item.status === false){
                                var item = `
                            <!--begin::Day-->
                            <div id="kt_schedule_day" class="tab-pane fade show active">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-6 alert alert-success">

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5">
                                        <!--begin::Time-->
                                        <div class="fs-7 mb-1">
                                            ${item.clock}

                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                            Boş
                                        </a>
                                        <!--end::Title-->


                                    </div>
                                    <!--end::Info-->
                                    <!--begin::Action-->
                                    <a href="${appointmentCreateRoute}" class="btn btn-light bnt-active-light-primary btn-sm">Randevu Al</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->

                            </div>
                            <!--end::Day-->
                            `;
                            } else{
                                var item = `
                            <!--begin::Day-->
                            <div id="kt_schedule_day" class="tab-pane fade show active">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-6 alert alert-${item.color_code} align-items-center">
                                    <div class="d-flex">
                                        <img src="${item.customer.image}" class="mt-2 rounded" style="width: 50px; height: 50px; object-fit: cover">
                                         <!--begin::Info-->
                                    <div class="fw-semibold ms-5">

                                        <!--begin::Time-->
                                        <div class="fs-7 mb-1">
                                            ${item.clock}
                                            <span style="color: ${item.salon_color}">(${item.salon})</span>

                                        </div>
                                        <!--end::Time-->

                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                            ${item.title}
                                        </a>
                                        <!--end::Title-->

                                        <!--begin::User-->
                                        <div class="fs-7 text-muted">
                                            Müşteri <a href="#">${item.customer.name}</a>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Info-->
                                    </div>


                                    <!--begin::Action-->
                                    <a href="${item.route}" class="btn btn-light bnt-active-light-primary btn-sm">Detay</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Time-->

                            </div>
                            <!--end::Day-->
                        `;
                            }

                            items += item;
                        });
                    } else{
                        var item = `
                            <!--begin::Day-->
                            <div id="kt_schedule_day" class="tab-pane fade show active">
                                <!--begin::Time-->
                                <div class="d-flex flex-stack position-relative mt-6 alert alert-success">

                                    <!--begin::Info-->
                                    <div class="fw-semibold ms-5">
                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 fw-bold text-dark text-hover-primary mb-2">
                                            Veri Bulunamadı
                                        </a>
                                        <!--end::Title-->


                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Time-->

                            </div>
                            <!--end::Day-->
                            `;

                        items+= item;
                    }
                    setTimeout(function() {
                        document.getElementById('loader').style.display = 'none';
                        container.innerHTML = items;
                    }, 1000)

                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        html: 'Sistemsel Bir Hata Sebebiyle Randevu Listesi Alınamadı',
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        }
    </script>

    <script src="/business/assets/js/project/personel-account/appointment/add.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        var mySelect = new TomSelect("#customer_select", {
            remoteUrl: '/personel/speed-appointment/customer',
            remoteSearch: true,
            create: false,
            highlight: false,
            render: {
                no_results: function (data, escape) {
                    return '<div class="no-results">Sonuç bulunamadı.</div>';
                }
            },
            load: function (query, callback) {
                $.ajax({
                    url: '/personel/speed-appointment/customer', // Sunucu tarafındaki arama API'sinin URL'si
                    method: 'GET',
                    data: {
                        name: query,
                    }, // Arama sorgusu
                    dataType: 'json', // Beklenen veri tipi
                    success: function (data) {
                        var results = data.map(function (item) {
                            return {
                                value: item.id,
                                text: item.name,
                            };
                        });
                        callback(results);
                    },
                    error: function () {
                        console.error("Arama sırasında bir hata oluştu.");
                    }
                });
            }
        });
        var personelId = null;
        $('#personel_select').on('change', function () {
            personelId = $(this).val();
            var serviceSelect = $('#service_select');
            $.ajax({
                url: '/personel/speed-appointment/personel/' + personelId + '/services', // Sunucu tarafındaki arama API'sinin URL'si
                method: 'GET',
                dataType: 'json', // Beklenen veri tipi
                success: function (res) {
                    serviceSelect.empty();
                    $.each(res, function (index, item) {
                        serviceSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                },
                error: function () {
                    console.error("Arama sırasında bir hata oluştu.");
                }
            });
        });
        $('.roomCheckBox').on('change', function (){
            var room_id = $(this).val();
            fetchPersonel(room_id);
        })
        function fetchPersonel(room_id = null){
            var personelSelect = $('#personel_select');
            $.ajax({
                url: '/personel/speed-appointment/personel/list',
                method: 'GET',
                data: {
                    'room_id' : room_id,
                },
                dataType: 'json', // Beklenen veri tipi
                success: function (res) {
                    personelSelect.empty();
                    personelSelect.append('<option value="' + 0 + '">Personel Seçiniz</option>');

                    $.each(res, function (index, item) {
                        personelSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                },
                error: function () {
                    console.error("Arama sırasında bir hata oluştu.");
                }
            });
        }
        $(function (){
            var roomCheckBox = $('.roomCheckBox');

            if(roomCheckBox.length > 0){
                var checkedRoom = $('.roomCheckBox:checked').val();
                fetchPersonel(checkedRoom);
            } else{
                fetchPersonel();
            }

        })
        $('#date_select').on('change', function (){
            var selectedDate = $(this).val();
            var start_time_select = $('#start_time_select');
            var end_time_select = $('#end_time_select');
            $.ajax({
                url: '/personel/speed-appointment/personel/' + personelId + '/clocks', // Sunucu tarafındaki arama API'sinin URL'si
                method: 'GET',
                data: {
                    appointment_date : selectedDate,
                },
                dataType: 'json', // Beklenen veri tipi
                success: function (res) {
                    start_time_select.empty();
                    end_time_select.empty();
                    $.each(res, function (index, item) {

                        start_time_select.append('<option value="' + item.value + '">' + item.saat + '</option>');
                        end_time_select.append('<option value="' + item.value + '">' + item.saat + '</option>');
                    });
                },
                error: function () {
                    console.error("Arama sırasında bir hata oluştu.");
                }
            });
        });

    </script>
@endsection
