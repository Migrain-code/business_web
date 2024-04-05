"use strict";

// Class definition
var KTModalPaymentAdd = function () {
    var submitButtonPayment;
    var cancelButtonPayment;
    var closeButtonPayment;
    var validator;
    var formPayment;
    var paymentModal;

    // Init formPayment inputs
    var handleformPayment = function () {
        // Init formPayment validation rules. For more info check the formPaymentValidation plugin's official documentation:https://formPaymentvalidation.io/
        validator = FormValidation.formValidation(
            formPayment,
            {
                fields: {
                    'collectionPaymentType': {
                        validators: {
                            notEmpty: {
                                message: 'Ödeme Tipi Seçiniz'
                            }
                        }
                    },
                    'collectionPrice': {
                        validators: {
                            notEmpty: {
                                message: 'Fiyat Alanı Gereklidir'
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
        submitButtonPayment.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate formPayment before submit
            if (validator) {
                validator.validate().then(function (status) {

                    if (status == 'Valid') {
                        submitButtonPayment.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        submitButtonPayment.disabled = true;

                        setTimeout(function() {
                            submitButtonPayment.removeAttribute('data-kt-indicator');
                            var formPaymentData = new FormData();
                            formPaymentData.append("_token", csrf_token);
                            formPaymentData.append("price", $('[name="collectionPrice"]').val());
                            formPaymentData.append("paymentType", $('[name="collectionPaymentType"]').val());

                            $.ajax({
                                url: '/isletme/adission/'+ adissionId +'/payment/add',
                                type: "POST",
                                data: formPaymentData,
                                processData: false,
                                contentType: false,
                                dataType: "JSON",
                                success: function (res) {
                                    Swal.fire({
                                        text: res.message,
                                        icon: res.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Tamam, Devam Et!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        submitButtonPayment.disabled = false;
                                        if (res.status != "error"){
                                            formPayment.reset(); // Reset formPayment
                                            paymentModal.hide(); // Hide modal

                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        }
                                    });

                                },
                                error: function (xhr) {
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

                        }, 2000);
                    } else {
                        $('.flatpickr-calendar').css('z-index', '1060');

                        Swal.fire({
                            text: "Bazı Sorunlar Oluştu Lütfen Zorunlu Alanları Kontrol Ediniz.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Tamam, Devam et!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });

        cancelButtonPayment.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                text: "Tahsilat Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
                icon: "warning",
                showcancelButtonPayment: true,
                buttonsStyling: false,
                confirmButtonText: "Evet, İptal Et!",
                cancelButtonPaymentText: "Hayır, Devam Et",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButtonPayment: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    formPayment.reset(); // Reset formPayment
                    paymentModal.hide(); // Hide modal
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "İşlem İptal Edilmedi!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tamam, devam et!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

        closeButtonPayment.addEventListener('click', function(e){
            e.preventDefault();
            Swal.fire({
                text: "Tahsilat Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
                icon: "warning",
                showcancelButtonPayment: true,
                buttonsStyling: false,
                confirmButtonText: "Evet, İptal Et!",
                cancelButtonPaymentText: "Hayır, Devam Et",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButtonPayment: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    formPayment.reset(); // Reset formPayment
                    paymentModal.hide(); // Hide paymentModal
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "İşlem İptal Edilmedi!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Tamam, devam et!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });

        })
    }

    return {
        // Public functions
        init: function () {
            // Elements
            paymentModal = new bootstrap.Modal(document.querySelector('#kt_modal_add_payment'));
            formPayment = document.querySelector('#kt_modal_add_payment_form');
            submitButtonPayment = formPayment.querySelector('#kt_modal_add_payment_submit');
            cancelButtonPayment = formPayment.querySelector('#kt_modal_add_payment_cancel');
            closeButtonPayment = formPayment.querySelector('#kt_modal_add_payment_close');
            handleformPayment();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalPaymentAdd.init();
});
