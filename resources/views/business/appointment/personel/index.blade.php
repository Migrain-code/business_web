@extends('business.layouts.master')
@section('title', 'Randevular')
@section('styles')
    <style>
        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
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
        Randevular
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="col-xxl-12 mb-5 mb-xl-10">
            <div class="card card-flush mb-6 mb-xl-9">
                <!--begin::Card header-->
                <div class="card-header mt-6 align-items-center">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h2 class="mb-1">Personel Randevu Takvimi</h2>

                        <div class="fs-6 fw-semibold text-muted">Seçtiğiniz personelin hangi gündeki randevularını görmek istiyorsanız. O güne tıklayınız.</div>
                    </div>
                    <select id="personelSelectArea" id="city_select" aria-label="Personel Seçiniz" data-control="select2" data-placeholder="Personel Seçiniz..." data-dropdown-parent="#kt_app_content" class="form-select form-select-solid fw-bold">
                        @foreach($personels as $personel)
                            <option value="{{$personel->id}}" @selected($loop->first)>{{$personel->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body p-9 pt-4">
                    <!--begin::Dates-->
                    <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2 scrollable-container">
                        @foreach($dates as $date)
                            <!--begin::Date-->
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary clickedDate @if($date["value"] == now()->format('Y-m-d')) active @endif"
                                   data-bs-toggle="tab" href="#kt_schedule_day" data-date="{{$date["value"]}}">

                                    <span class="opacity-50 fs-7 fw-semibold">{{$date["day"]}}</span>
                                    <span class="fs-6 fw-bolder">{{$date["date"]}}</span>
                                </a>
                            </li>
                            <!--end::Date-->
                        @endforeach

                    </ul>
                    <!--end::Dates-->

                    <!--begin::Tab Content-->
                    <div class="tab-content position-relative min-h-150px">
                        <div id="loader" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="scroll-y me-n7 pe-7" id="clockContainer" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="200px">

                        </div>
                        <div class="w-100 mt-5 d-flex align-items-center justify-content-center scrollBottomButton">
                            <i class="fa fa-chevron-down fs-2"></i>
                        </div>
                    </div>
                    <!--end::Tab Content-->
                </div>
                <!--end::Card body-->
            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $('.clickedDate').on('click', function () {
            var date = $(this).data('date');
            fetchAppointment(date);
        });
        $(document).ready(function (){
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
            var personelId = $('#personelSelectArea').val();
            document.getElementById('loader').style.display = 'block';
            var container = document.getElementById('clockContainer');
            container.innerHTML="<div></div>";
            $.ajax({
                url: `/isletme/personel/${personelId}/appointment`,
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

@endsection
