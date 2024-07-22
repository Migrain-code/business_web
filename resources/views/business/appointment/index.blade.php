@extends('business.layouts.master')
@section('title', 'Randevular')
@section('styles')

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
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
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
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <div class="card pt-4 mb-6 mb-xl-9 ">
            <!--begin::Card header-->
            <div class="card-header border-0">
                <!--begin::Card title-->
                <div class="card-title" style="display: block;">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                    class="path1"></span><span class="path2"></span></i> <input
                                type="text" data-kt-customer-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13"
                                placeholder="Randevularda Ara">
                        </div>
                        <!--end::Search-->
                    </div>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Filter-->
                        <div class="w-150px me-3">
                            <!--begin::Select2-->
                            <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Durumu"
                                    data-kt-ecommerce-order-filter="status">
                                <option></option>
                                <option value="all">Tümü</option>
                                <option value="Onay Bekliyor">Onay Bekliyor</option>
                                <option value="Onaylandı">Onaylandı</option>
                                <option value="Tamamlandı">Tamamlandı</option>
                                <option value="İptal Edildi">İptal Edildi</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                        <!--end::Filter-->

                        <!--begin::Add customer-->
                        <a href="{{route('business.appointmentCreate.index')}}" {{-- data-bs-toggle="modal" data-bs-target="#kt_modal_add_appointment" --}}
                           class="btn btn-primary me-1">
                            Randevu Oluştur
                        </a>

                        <!--begin::Export-->
                        <!--begin::Export dropdown-->
                        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                        <!--begin::Menu-->
                        <div id="kt_ecommerce_report_customer_orders_export_menu"
                             class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                             data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="copy">
                                    Panoya Kopyala
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="excel">
                                    Excel
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="csv">
                                    CSV
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="pdf">
                                    PDF
                                </a>
                            </div>
                            <!--end::Menu item-->

                        </div>
                        <!--end::Menu-->
                        <!--end::Export-->
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none"
                         data-kt-customer-table-toolbar="selected">
                        <div class="fw-bold me-5">
                                                <span class="me-2"
                                                      data-kt-customer-table-select="selected_count"></span> Selected
                        </div>

                        <button type="button" class="btn btn-danger"
                                data-kt-customer-table-select="delete_selected">
                            Delete Selected
                        </button>
                    </div>
                    <!--end::Group actions-->        </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0 pb-5">
                <!--begin::Table wrapper-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Müşteri</th>
                            <th class="min-w-125px">Salon</th>
                            <th class="min-w-125px">Hizmetler</th>
                            <th class="min-w-125px">Tarih</th>
                            <th class="min-w-125px">Saat</th>
                            <th class="min-w-125px">Durum</th>
                            <th class="min-w-125px">Toplam Hizmet Fiyatı</th>
                            <th class="text-end min-w-70px">İşlemler</th>
                        </tr>
                        </thead>
                        <!--begin::Table body-->
                        <tbody class="fs-6 fw-semibold text-gray-600">

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table wrapper-->
            </div>
            <!--end::Card body-->
        </div>
        @include('business.appointment.modals.add-new-appointment')
        @include('business.appointment-create.modal.add-customer')

    </div>
@endsection
@section('scripts')
    <script>
        let DATA_URL = "{{route('business.appointment.datatable')}}";
        let DATA_COLUMNS = [
            {data: 'customerName'},
            {data: 'room_id'},
            {data: 'services'},
            {data: 'start_time'},
            {data: 'clock'},
            {data: 'status'},
            {data: 'servicePrice'},
            {data: 'action'}
        ];
    </script>
    <script>
        var apppointmentType = "appointmentCreate";
    </script>
    <script src="/business/assets/js/project/appointment/add-customer.js"></script>
    <script src="/business/assets/js/project/appointment/listing.js"></script>
    <script src="/business/assets/js/project/appointment/add.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        var mySelect = new TomSelect("#customer_select", {
            remoteUrl: '/isletme/speed-appointment/customer',
            remoteSearch: true,
            create: false,
            highlight: false,
            render: {
                no_results: function (data, escape) {
                    return '<div class="no-results">Sonuç bulunamadı.</div>';
                }
            },
            load: function (query, callback) {
                if (query.length > 3) {
                    $.ajax({
                        url: this.settings.remoteUrl,
                        method: 'GET',
                        data: { name: query },
                        dataType: 'json',
                        success: function (data) {
                            var results = data.map(function (item) {
                                return {
                                    value: item.id,
                                    text: item.name + " -> 0" + item.phone,
                                };
                            });
                            callback(results);
                        },
                        error: function () {
                            console.error("Arama sırasında bir hata oluştu.");
                            callback([]); // Hata durumunda boş bir dizi gönder
                        }
                    });
                } else {
                    callback([]); // Sorgu uzunluğu yeterli değilse boş bir dizi gönder
                }
            }
        });


        var personelId = null;
        $('#personel_select').on('change', function () {
            personelId = $(this).val();
            var serviceSelect = $('#service_select');
            var room_select_area = $('#roomSelectArea');
            $.ajax({
                url: '/isletme/speed-appointment/personel/' + personelId + '/services',
                method: 'GET',
                dataType: 'json', // Beklenen veri tipi
                success: function (res) {
                    serviceSelect.empty();
                    room_select_area.empty();
                    $.each(res.services, function (index, item) {
                        serviceSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                    var rooms = "";
                    $.each(res.rooms, function (index, item) {
                       rooms+=`<div class="col-lg-6 col-12">
                                        <!--begin::Radio button-->
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5" style="min-width: 200px">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input roomCheckBox" type="radio" name="room_id" value="${item.id}"/>
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                        ${item.name}
                                                   </h2>
                                               </div>
                                               <!--end::Info-->
                                           </div>
                                           <!--end::Description-->
                                       </label>
                                       <!--end::Radio button-->
                                   </div>`
                    });
                    document.getElementById('roomSelectArea').innerHTML = rooms;
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
                url: '/isletme/speed-appointment/personel/list',
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

        $('#date_select').on('change', function (){
            var selectedDate = $(this).val();
            $.ajax({
                url: '/isletme/speed-appointment/personel/' + personelId + '/clocks',
                method: 'GET',
                data: {
                    appointment_date : selectedDate,
                },
                dataType: 'json', // Beklenen veri tipi
                success: function (res) {
                    var clocks = "";
                    if(res.status == "error"){
                        Toast.fire({
                            icon: res.status,
                            title: res.message,

                        })
                    } else{
                        $.each(res, function(index, item){
                            clocks += `
                            <div class="col-lg-2 col-4">
                                <input type="radio" class="btn-check" name="start_time" value="${item.value}"  id="kt_radio_buttons_2_option_${item.value}"/>
                                <label class="btn btn-outline btn-outline-dashed btn-light-success p-4 d-flex align-items-center mb-5" style="border-radius: 15px" for="kt_radio_buttons_2_option_${item.value}">
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">${item.saat}</span>
                                 </span>
                                </label>
                            </div>
                        `
                        });
                    }

                    document.getElementById('clockContainer').innerHTML = clocks;
                },
                error: function () {
                    console.error("Arama sırasında bir hata oluştu.");
                }
            });
        });

    </script>
@endsection
