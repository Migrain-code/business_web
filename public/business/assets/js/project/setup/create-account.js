"use strict";

var KTCreateAccount = function() {
    var modal, stepper, form, submitBtn, nextBtn, stepperInstance;

    function initStepper() {
        stepperInstance = new KTStepper(stepper);
        stepperInstance.on("kt.stepper.changed", handleStepChange);
        stepperInstance.on("kt.stepper.next", handleNextStep);
        stepperInstance.on("kt.stepper.previous", handlePreviousStep);

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
        } else if (currentStep == 2){
           updateStep2();
        } else if (currentStep == 3){
           updateStep3();
        }

        stepperInstance.goNext();
        KTUtil.scrollTop();

    }
    function updateStep1(){
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("category_id", $('[name= "category_id"]').val());
        $.ajax({
            url: '/isletme/setup/step-1',
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
    function updateStep2(){
        var content = quill.root.innerHTML;
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("team_size", $('[name= "team_size"]').val());
        formData.append("business_name", $('[name= "business_name"]').val());
        formData.append("business_phone", $('[name= "business_phone"]').val());
        formData.append("business_type", $('[name= "business_type"]').val());
        formData.append("city_id", $('[name= "city_id"]').val());
        formData.append("district_id", $('[name= "district_id"]').val());
        formData.append("off_day_id", $('[name= "close_day"]').val());
        formData.append("start_time", $('[name= "start_time"]').val());
        formData.append("end_time", $('[name= "end_time"]').val());
        formData.append("about_content", content);

        $.ajax({
            url: '/isletme/setup/step-2',
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
    function updateStep3(){
        var formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("latitude", $('[name= "latitude"]').val());
        formData.append("longitude", $('[name= "longitude"]').val());
        formData.append("address", $('[name= "address"]').val());
        formData.append("embed", $('[name= "emebed"]').val());
        $.ajax({
            url: '/isletme/setup/step-3',
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
