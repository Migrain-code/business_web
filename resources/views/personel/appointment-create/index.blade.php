@extends('personel.layouts.master')
@section('title', 'Randevu Oluştur')
@section('styles')
    <style>
        /*
            #tabMenus .nav-line-tabs .nav-item .nav-link {
            margin-left: 0;
            font-size: 20px;
            font-weight: 700;
            padding: 15px;
            min-width: 150px;
            text-align: center;
            color: rgba(255, 255, 255, 0.49);
            background-color: rgba(80, 205, 137, 0.36);
        }
        #tabMenus .nav-line-tabs .nav-item .nav-link.active, .nav-line-tabs .nav-item .nav-link:hover:not(.disabled), .nav-line-tabs .nav-item.show .nav-link {
            background-color: transparent;
            border: 0;
            border-bottom: 1px solid var(--bs-primary);
            transition: color .2s ease;
            background: var(--bs-primary);
            color: white;
            padding: 15px;
        }

        */
        input[type="radio"]:disabled + label {
            border-color: red !important; /* Kırmızı bir çizgi için */
            background-color: rgba(255, 0, 0, 0.1) !important; /* Kırmızı arka plan için */
        }
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
        <a href="{{route('personel.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Randevu Oluştur
    </li>
    <!--end::Item-->

@endsection
@section('content')

    <div id="kt_app_content" class="app-content ">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills w-100" id="kt_stepper_example_basic" style="background-color: #1e1e2d;
    border-radius: 40px;
    padding: 30px;">
            <!--begin::Nav-->
            <div class="stepper-nav flex-center flex-wrap mb-10 w-100">
                <!--begin::Step 1-->
                <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                    <!--begin::Wrapper-->
                    <div class="stepper-wrapper d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">1</span>
                        </div>
                        <!--end::Icon-->

                        <!--begin::Label-->
                        <div class="stepper-label">
                            <h3 class="stepper-title">
                                1. Adım
                            </h3>

                            <div class="stepper-desc">
                                Hizmet Seçimi
                            </div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Line-->
                    <div class="stepper-line h-40px"></div>
                    <!--end::Line-->
                </div>
                <!--end::Step 1-->

                <!--begin::Step 2-->
                <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                    <!--begin::Wrapper-->
                    <div class="stepper-wrapper d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">2</span>
                        </div>
                        <!--begin::Icon-->

                        <!--begin::Label-->
                        <div class="stepper-label">
                            <h3 class="stepper-title">
                                2. Adım
                            </h3>

                            <div class="stepper-desc">
                                Personel Seçimi
                            </div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Line-->
                    <div class="stepper-line h-40px"></div>
                    <!--end::Line-->
                </div>
                <!--end::Step 2-->

                <!--begin::Step 3-->
                <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                    <!--begin::Wrapper-->
                    <div class="stepper-wrapper d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">3</span>
                        </div>
                        <!--begin::Icon-->

                        <!--begin::Label-->
                        <div class="stepper-label">
                            <h3 class="stepper-title">
                                3.Adım
                            </h3>

                            <div class="stepper-desc">
                                Saat Seçimi
                            </div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Line-->
                    <div class="stepper-line h-40px"></div>
                    <!--end::Line-->
                </div>
                <!--end::Step 3-->

                <!--begin::Step 4-->
                <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                    <!--begin::Wrapper-->
                    <div class="stepper-wrapper d-flex align-items-center">
                        <!--begin::Icon-->
                        <div class="stepper-icon w-40px h-40px">
                            <i class="stepper-check fas fa-check"></i>
                            <span class="stepper-number">4</span>
                        </div>
                        <!--begin::Icon-->

                        <!--begin::Label-->
                        <div class="stepper-label">
                            <h3 class="stepper-title">
                                4.Adım
                            </h3>

                            <div class="stepper-desc">
                                Müşteri Seçimi
                            </div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Line-->
                    <div class="stepper-line h-40px"></div>
                    <!--end::Line-->
                </div>
                <!--end::Step 4-->

            </div>
            <!--end::Nav-->

            <!--begin::Form-->
            <form class="form w-lg-650px mx-auto" method="post" action="{{route('personel.appointmentCreate.store')}}" novalidate="novalidate" id="kt_stepper_example_basic_form">
                <!--begin::Group-->
                @csrf
                <div class="mb-5">
                    @include('personel.appointment-create.steps.step-1')
                    @include('personel.appointment-create.steps.step-2')
                    @include('personel.appointment-create.steps.step-3')
                    @include('personel.appointment-create.steps.step-4')
                </div>
                <!--end::Group-->

                <!--begin::Actions-->
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="me-2">
                        <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                            Önceki
                        </button>
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Wrapper-->
                    <div>
                        <button type="button" class="btn btn-primary" data-kt-stepper-action="submit">
                            <span class="indicator-label">
                                Oluştur
                            </span>
                            <span class="indicator-progress">
                        Lütfen Bekleyin... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                        </button>

                        <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                            Sonraki
                        </button>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Stepper-->

    </div>

@endsection
@section('scripts')
    <script>
        $('#searchCustomer').on('input keypress', function() {
            var searchValue = $(this).val().toLowerCase(); // Arama değerini küçük harfe çevir

            var options = $('[data-name]'); // Tüm data-name özelliğine sahip elementleri seç

            options.each(function(index,customer) {

                var name = $(this).attr('data-name').toLowerCase(); // Her bir elementin data-name değerini küçük harfe çevir

                // Eğer arama değeri elementin data-name değerinde bulunuyorsa, elementi göster, aksi takdirde gizle

                if (name.includes(searchValue)) {
                    $(this).css('display', 'block'); // Elementi göster
                } else {
                    $(this).css('display', 'none'); // Elementi gizle ve yerini boş bırak
                }
            });
        });
    </script>

    <script>

        // Stepper lement
        var element = document.querySelector("#kt_stepper_example_basic");

        // Initialize Stepper
        var stepper = new KTStepper(element, {
            startIndex: 0 // Adımların 0'dan başlamasını sağlar
        });

        // Handle next step
        stepper.on("kt.stepper.next", function (stepper) {
            if(stepper.currentStepIndex === 1){
                //personeller
                getPersonel();
            }
            else if(stepper.currentStepIndex === 2){
               getDate();
            }
            else if(stepper.currentStepIndex === 3){
                getCustomer()
            }

            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function (stepper) {
            console.log('index',stepper.currentStepIndex);

            stepper.goPrevious(); // go previous step
        });


        function getPersonel(){
            var formData = new FormData();
            formData.append("_token", csrf_token);
            var inputs = document.querySelectorAll('input[name="services[]"]');
            var selectedServiceCount = 0;
            if (inputs.length > 0) {
                inputs.forEach(function(input) {
                    if (input.checked) {
                        formData.append(input.name, input.value);
                        selectedServiceCount++;
                    }
                });
            }
            if(selectedServiceCount === 0){
                Swal.fire({
                    title: "Hizmet seçimi yapmadan personel seçimine geçemezsiniz.",
                    text: "Lütfen Hizmet Seçiniz",
                    icon: 'error',
                });
                stepper.currentStepIndex = 0;
            }
            else{
                $.ajax({
                    url: '/personel/appointment-create/get/personel',
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function (res) {

                        var services = "";
                        $.each(res, function(index, item) {
                            // Her bir öğeyi konsola yazdır
                            var loop = 0;
                            services +=
                                ` <!--begin::Item-->
                                    <div class="mb-5">
                                        <!--begin::Header-->
                                        <div class="accordion-header py-3 d-flex" data-app-type="service" data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_item_${item.id}">
                                        <span class="accordion-icon">
                                            <i class="ki-duotone ki-plus-square fs-1 accordion-icon-off">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <i class="ki-duotone ki-minus-square fs-1 accordion-icon-on">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                            <h3 class="fs-2 fw-semibold mb-0 ms-4">${item.title}</h3>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div id="kt_accordion_3_item_${item.id}" class="fs-6 collapse show ps-10" data-bs-parent="#kt_accordion_personel_select">

                                            <!-- Personelsi için eklenen kısım -->
                                            ${item.personels.length > 0 ? item.personels.map(personel => `
                                                <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 15px">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                        <input class="form-check-input serviceChecks w-25px h-25px" name="personel[${item.id}]" type="radio" value="${personel.id}">
                                                    </div>
                                                    <span>${personel.name}</span>
                                                </div>
                                            `).join('') : `
                                                <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 15px">

                                                    <span class="alert alert-danger border-dashed p-3 m-3 w-100 text-center"> Bu hizmet için personel bulunamadı</span>
                                                </div>
                                            `}
                                            <!-- Personelsi için eklenen kısım sonu -->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Item-->
                                `;
                        });
                        document.getElementById('kt_accordion_personel_select').innerHTML= services;
                    },
                });

            }
        }

        function getDate(){
            var personelInputs = document.querySelectorAll('input[name^="personel"]');
            var personelValues = [];
            personelInputs.forEach(function(input) {
                // Eğer input checked ise, değerini diziye ekle
                if (input.checked) {
                    personelValues.push(input.value);
                }
            });
            var serviceElements = document.querySelectorAll('[data-app-type="service"]');

            if(personelValues.length === 0 || serviceElements.length !== personelValues.length){
                Swal.fire({
                    title: "Her Hizmet için 1 personel seçmeden Tarih/Saat seçim adımına geçemezsiniz.",
                    text: "Lütfen Personel Seçiniz",
                    icon: 'error',
                });
                stepper.currentStepIndex = 1;
            } else {
                $.ajax({
                    url: '/personel/appointment-create/get/date',
                    type: "GET",
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function (res) {

                        var dates = "";
                        var counter = 0;
                        $.each(res.dates, function(index, item) {

                            dates += `
                            <li class="nav-item me-1">
                                <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary ${counter === 0 ? 'active': ''}" onclick="getClock('${item.value}')" data-bs-toggle="tab">
                                    <span class="opacity-75 fs-5 fw-semibold">${item.date}</span>
                                    <span class="fs-6 fw-bolder">${item.day}</span>
                                </a>
                            </li>
                        `;
                            counter++;
                        });
                        document.getElementById('dateContainer').innerHTML= dates;
                        var now = new Date();
                        getClock(now.toLocaleDateString());
                    },
                });
            }

        }

        function getClock(clickedDate){
            document.getElementById('clockContainer').innerHTML = "";
            document.getElementById('loader').style.display = 'block';

            // Tüm personel inputlarını seç
            var personelInputs = document.querySelectorAll('input[name^="personel"]');

            var personelValues = [];

            personelInputs.forEach(function(input) {
                // Eğer input checked ise, değerini diziye ekle
                if (input.checked) {
                    personelValues.push(input.value);
                }
            });
                var clocks = "";
                $.ajax({
                    url: '/personel/appointment-create/get/clock',
                    type: "POST",
                    data: {
                        '_token' : csrf_token,
                        'personelIds' : personelValues,
                        'date': clickedDate
                    },
                    dataType: "JSON",
                    success: function (res) {
                        if(res.status === "error"){
                                Swal.fire({
                                    title: res.message,
                                    icon: res.status,
                                });
                            clocks += `
                                <div class="col-12">
                                    <input type="radio" class="btn-check" name="clock"  id="kt_radio_buttons_2_option_error" disabled />
                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-4 d-flex align-items-center mb-5" style="border-radius: 15px !important;" for="kt_radio_buttons_2_option_error">
                                    <span class="d-block fw-semibold text-start">
                                        <span class="text-gray-900 fw-bold d-block fs-3">${res.message}</span>
                                     </span>
                                    </label>
                                </div>
                            `
                        } else{
                            var counter = 0;
                            $.each(res, function(index, item){
                                clocks += `
                            <div class="col-3">
                                <input type="radio" class="btn-check" name="clock" value="${item.value}"  id="kt_radio_buttons_2_option_${item.value}" ${item.durum === false ? 'disabled' : ""}/>
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-4 d-flex align-items-center mb-5" style="border-radius: 15px !important;" for="kt_radio_buttons_2_option_${item.value}">
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">${item.saat}</span>
                                 </span>
                                </label>
                            </div>
                        `
                            });
                        }


                    }
                });
                setTimeout(function() {
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('clockContainer').innerHTML = clocks;
                }, 1000)
        }

        function getCustomer(){
            var checkedInputs = document.querySelectorAll('input[name="clock"]:checked');
            if(checkedInputs.length === 0){
                Swal.fire({
                    title: "Saat seçimi yapmadan müşteri seçimine geçemezsiniz.",
                    text: "Lütfen Saat Seçiniz",
                    icon: 'error',
                });
                stepper.currentStepIndex = 2;
            }
            $.ajax({
                url: '/personel/appointment-create/get/customers',
                type: "GET",
                dataType: "JSON",
                success: function (res) {
                    var customers = "";
                    $.each(res, function(index, item){
                        customers += `
                        <div data-name="${item.name}">
                             <!--begin:Option-->
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <!--begin:Label-->
                                <span class="d-flex align-items-center me-2">
                                <!--begin:Icon-->
                                    <span class="symbol symbol-50px me-6">
                                        <img src="${item.image}">
                                    </span>
                                    <!--end:Icon-->

                                    <!--begin:Info-->
                                    <span class="d-flex flex-column">
                                        <span class="fw-bold fs-6">${item.name}</span>
                                    </span>
                                    <!--end:Info-->
                                </span>
                                <!--end:Label-->

                                <!--begin:Input-->
                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" required  name="customer_id" value="${item.id}"/>
                                </span>
                                <!--end:Input-->
                            </label>
                            <!--end::Option-->
                        </div>
                        `
                    });

                    document.getElementById('customerContainer').innerHTML = customers;

                }
            });
        }

        var submitButton = document.querySelector('[data-kt-stepper-action="submit"]');

        submitButton.addEventListener('click', function(event) {
            var checkedInputsCustomer = document.querySelectorAll('input[name="customer_id"]:checked');
            if(checkedInputsCustomer.length === 0){
                Swal.fire({
                    title: "Müşteri Seçimi Yapmadan Randevu Oluşturamazsınız.",
                    text: "Lütfen Müşteri Seçiniz",
                    icon: 'error',
                });
                stepper.currentStepIndex = 3;
            }
            else{
                $('#kt_stepper_example_basic_form').submit();
            }
            event.preventDefault();
        });
    </script>

@endsection