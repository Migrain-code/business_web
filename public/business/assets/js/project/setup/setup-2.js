"use strict";

var KTCreateAccount = function() {
    var modal, stepper, form, submitBtn, nextBtn, stepperInstance, modalPersonel, personelLength, serviceLength;

    function initStepper() {
        stepperInstance = new KTStepper(stepper);
        stepperInstance.on("kt.stepper.changed", handleStepChange);
        stepperInstance.on("kt.stepper.next", handleNextStep);
        stepperInstance.on("kt.stepper.previous", handlePreviousStep);
        modalPersonel = new bootstrap.Modal(document.querySelector('#kt_modal_add_personel'));

    }

    function handleStepChange(e) {
        var currentStep = stepperInstance.getCurrentStepIndex();
        if (currentStep === 4) {
            submitBtn.classList.remove("d-none");
            submitBtn.classList.add("d-inline-block");
            nextBtn.classList.add("d-none");
        } else if (currentStep === 5) {
            submitBtn.classList.add("d-none");
            nextBtn.classList.add("d-none");
        } else {
            submitBtn.classList.remove("d-inline-block");
            submitBtn.classList.remove("d-none");
            nextBtn.classList.remove("d-none");
        }
    }

    function handleNextStep(e) {
        var currentStep = stepperInstance.getCurrentStepIndex();
        if (currentStep == 1){
           updateStep1(); //1. adımı güncelle
            fetchServiceList();
        } else if (currentStep == 2){
            fetchServiceList();

            if (serviceLength == 0){
                stepperInstance.goPrevious();
                Swal.fire({
                    text: 'En az 1 hizmet eklemeniz gerekmektedir.',
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tamam!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        } else if (currentStep == 3){
            if (personelLength == 0){
                stepperInstance.goPrevious();
                Swal.fire({
                    text: 'En az 1 personel eklemeniz gerekmektedir. Eğer sadece çalışan sadece siz iseniz kendinizi personel olarak ekleyiniz.',
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Tamam!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        } else if (currentStep == 4){
            //updateStep4();
        }

        stepperInstance.goNext();
        KTUtil.scrollTop();

    }
    function updateStep1(){

        var formData = new FormData();
        formData.append("_token", csrf_token);

        formData.append("business_name", $('[name= "business_name"]').val());
        formData.append("business_phone", $('[name= "business_phone"]').val());
        formData.append("off_day_id", $('[name= "close_day"]').val());
        formData.append("start_time", $('[name= "start_time"]').val());
        formData.append("end_time", $('[name= "end_time"]').val());
        formData.append("appoinment_range", $('[name= "appoinment_range"]').val());
        formData.append("image", $('[name="avatar"]')[0].files[0]);

        $.ajax({
            url: '/isletme/detail-setup/step-1',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function (res) {
                Swal.fire({
                    text: res.message,
                    icon: res.status,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            },
            error: function (xhr) {
                stepperInstance.goPrevious();
                var errorMessage = "<ul>";
                xhr.responseJSON.errors.forEach(function (error) {
                    errorMessage += "<li>" + error + "</li>";
                });
                errorMessage += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    html: errorMessage,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
    $('.addServiceBtn').on('click',function (){
        let categoryId = $(this).data('category');
        let serviceId = $(this).data('service');
        $('[name= "service_id"]').val(serviceId)
        $('[name= "category_id"]').val(categoryId)
        modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_service'));
        modal.show();
    });
    $('#kt_modal_add_service_submit').on('click', function (){
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("subCategoryId", $('[name= "service_id"]').val());
        formData.append("categoryId", $('[name= "category_id"]').val());
        formData.append("price", $('[name= "price"]').val());
        formData.append("time", $('[name= "time"]').val());
        formData.append("typeId", $('[name= "gender"]').val());
        $.ajax({
            url: '/isletme/service',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function (res) {
                Swal.fire({
                    text: res.message,
                    icon: res.status,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                $('[name= "service_id"]').val("")
                $('[name= "category_id"]').val("")
                $('[name= "price"]').val("")
                $('[name= "time"]').val("")
                $('[name= "gender"]').val("")
                modal.hide();
                fetchServiceList();
            },
            error: function (xhr) {
                stepperInstance.goPrevious();
                var errorMessage = "<ul>";
                xhr.responseJSON.errors.forEach(function (error) {
                    errorMessage += "<li>" + error + "</li>";
                });
                errorMessage += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    html: errorMessage,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    });
    $('#add_personel_btn').on('click', function (){
        fetchPersonelList();
        fetchServiceList();
    });
    function fetchServiceList(){
        var serviceSelect = $('#serviceSelectInput');
        serviceSelect.empty();
        $.ajax({
            url: '/isletme/ajax/get/services',
            type: "POST",
            data: {
                "_token": csrf_token,
            },
            dataType: "JSON",
            success: function (res) {
                serviceLength = res.length;
                $.each(res, function (index, item) {
                    serviceSelect.append('<option value="' + item.sub_category_id + '">' + item.sub_category + '</option>');
                });

            }

        });
    }
    $('#kt_modal_add_personel_submit').on('click', function (){
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("name", $('[name= "name"]').val());
        formData.append("email", $('[name= "email"]').val());
        formData.append("phone", $('[name= "phone"]').val());
        formData.append("password", $('[name= "password"]').val());
        formData.append("approve_type", $('[name= "approve_type"]').val());
        formData.append("start_time", $('[name= "start_time"]').val());
        formData.append("end_time", $('[name= "end_time"]').val());
        formData.append("gender_type", $('[name= "gender_type"]').val());
        formData.append("rate", $('[name= "rate"]').val());
        formData.append("range", $('[name= "range"]').val());
        formData.append("product_rate", $('[name= "product_rate"]').val());
        formData.append("is_case", $('[name= "is_case"]').val());
        $('[name="services[]"]').find('option:selected').each(function() {
            formData.append("services[]", $(this).val());
        });
        $('[name="restDay[]"]').find('option:selected').each(function() {
            formData.append("restDay[]", $(this).val());
        });
        $.ajax({
            url: '/isletme/personel',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function (res) {
                if (res.status == "success"){
                    modalPersonel.hide();
                    document.getElementById('personelAddForm').reset();
                    fetchPersonelList();
                }
                Swal.fire({
                    text: res.message,
                    icon: res.status,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });


            },
            error: function (xhr) {

                var errorMessage = "<ul>";
                Object.keys(xhr.responseJSON.errors).forEach(function (errorType) {
                    var messages = xhr.responseJSON.errors[errorType];
                    messages.forEach(function (message) {
                        errorMessage += "<li>" + message + "</li>";
                    });
                });
                errorMessage += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    html: errorMessage,
                    buttonsStyling: false,
                    confirmButtonText: "Tamam",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    });
    $('#setupCompeteBtn').on('click', function (){
        window.location.href = "/isletme/home";
    });

    function fetchPersonelList(){
        var container= document.getElementById('personelList');
        container.innerHTML = "";
        var items = "";
        $.ajax({
            url: '/isletme/ajax/get/personel',
            type: "POST",
            data: {
                "_token": csrf_token,
            },
            dataType: "JSON",
            success: function (res) {
                personelLength = res.length;
                if (personelLength == 0){
                    items += `<div class="alert alert-warning d-flex align-items-center p-5 justify-content-center text-center">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                            <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column">
                                <!--begin::Content-->
                                <span>Kayıt Bulunamadı.</span>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>`
                } else{
                    $.each(res, function (index, item) {
                        items += `<div class="d-flex align-items-center py-2">
                    <img src="${item.image}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover">
                    <div class="text-gray-600 fw-bold fs-5 ps-4">
                       ${item.name}
                    </div>
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed"></div>
                <!--end::Separator-->`;
                    });
                }

                container.innerHTML = items;
            }

        });

    }
    function handlePreviousStep(e) {
        stepperInstance.goPrevious();
        KTUtil.scrollTop();
    }

    function init() {
        modal = document.querySelector("#kt_modal_create_account");
        if (modal) new bootstrap.Modal(modal);

        stepper = document.querySelector("#kt_create_account_stepper");
        form = stepper.querySelector("#kt_create_account_form");
        submitBtn = stepper.querySelector('[data-kt-stepper-action="submit"]');
        nextBtn = stepper.querySelector('[data-kt-stepper-action="next"]');

        initStepper();
    }

    return {
        init: init
    };
}();

KTUtil.onDOMContentLoaded(function() {
    KTCreateAccount.init();
});
