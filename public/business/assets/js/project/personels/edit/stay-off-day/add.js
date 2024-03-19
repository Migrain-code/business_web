"use strict";

// Class definition
var KTModalUsageAdd = function () {
    var submitButtonUsage;
    var cancelButtonUsage;
    var closeButtonUsage;
    var validatorUsage;
    var formUsage;
    var modal;

    // Init form inputs
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validatorUsage = FormValidation.formValidation(
            formUsage,
            {
                fields: {
                    'off_date': {
                        validatorUsages: {
                            notEmpty: {
                                message: 'İzin Başlangıç Tarihi Gereklidir'
                            }
                        }
                    },
                    'day_amount': {
                        validatorUsages: {
                            notEmpty: {
                                message: 'İzin Verilecek Gün Sayısı Gereklidir'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Action buttons
        submitButtonUsage.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate form before submit
            if (validatorUsage) {
                validatorUsage.validate().then(function (status) {
                    if (status == 'Valid') {
                        submitButtonUsage.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        submitButtonUsage.disabled = true;

                        setTimeout(function() {
                            submitButtonUsage.removeAttribute('data-kt-indicator');
                            var formData = new FormData();
                            formData.append("_token", csrf_token);
                            formData.append("off_date", $('[name="off_date"]').val());
                            formData.append("day_amount", $('[name="day_amount"]').val());
                            $('.flatpickr-calendar').removeClass('open');
                            $.ajax({
                                url: '/isletme/personel/'+ personelId +'/add-stay-off-day',
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: "JSON",
                                success: function (res) {
                                    $('.flatpickr-calendar').css('z-index', '1060');

                                    Swal.fire({
                                        text: res.message,
                                        icon: res.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Tamam, Devam Et!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        submitButtonUsage.disabled = false;
                                        if (res.status != "error"){
                                            formUsage.reset(); // Reset formUsage
                                            modal.hide(); // Hide modal

                                            if (result.isConfirmed) {
                                                location.reload();
                                                // Enable submit button after loading

                                                // Redirect to customers list page
                                                //window.location = form.getAttribute("data-kt-redirect");
                                            }
                                        }
                                    });

                                },
                                error: function (xhr) {
                                    submitButtonUsage.disabled = false;

                                    var errorMessage = "<ul>";
                                    xhr.responseJSON.errors.forEach(function (error) {
                                        errorMessage += "<li>" + error + "</li>";
                                    });
                                    errorMessage += "</ul>";
                                    $('.flatpickr-calendar').css('z-index', '1060');

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
                                    if (flatpickrInstance.calendarContainer) {
                                        // Flatpickr açık olduğunda, kapatın
                                        flatpickrInstance.close();
                                    } else {
                                        // Flatpickr kapalı olduğunda, açın
                                        flatpickrInstance.open();
                                    }
                                }
                            });

                        }, 2000);
                    } else {
                        Swal.fire({
                            text: "Bazı Sorunlar Oluştu Lütfen Zorunlu Alanları Kontrol Ediniz.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

        cancelButtonUsage.addEventListener('click', function (e) {
            e.preventDefault();

            formUsage.reset(); // Reset form
            modal.hide(); // Hide modal
        });

        closeButtonUsage.addEventListener('click', function(e){
            e.preventDefault();
            formUsage.reset(); // Reset form
            modal.hide(); // Hide modal

        })
    }

    return {
        // Public functions
        init: function () {
            // Elements
            modal = new bootstrap.Modal(document.querySelector('#stay_off_day_add_modal'));

            formUsage = document.querySelector('#kt_modal_add_personel_stay_off_day');
            submitButtonUsage = formUsage.querySelector('#kt_modal_add_customer_submit_usage');
            cancelButtonUsage = formUsage.querySelector('#kt_modal_add_customer_cancel_usage');
            closeButtonUsage = formUsage.querySelector('#kt_modal_add_customer_close_usage');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalUsageAdd.init();
});
