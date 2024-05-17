"use strict";

// Class definition
var KTModalReceivableAdd = function () {
    var submitButtonReceivable;
    var cancelButtonReceivable;
    var closeButtonPayment;
    var validator;
    var formReceivable;
    var receivableModal;

    // Init formReceivable inputs
    var handleformReceivable = function () {
        validator = FormValidation.formValidation(
            formReceivable,
            {
                fields: {
                    'paymentDate': {
                        validators: {
                            notEmpty: {
                                message: 'Ödeme Tipi Seçiniz'
                            }
                        }
                    },
                    'recivablePrice': {
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
        submitButtonReceivable.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate formReceivable before submit
            if (validator) {
                validator.validate().then(function (status) {

                    if (status == 'Valid') {
                        submitButtonReceivable.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        submitButtonReceivable.disabled = true;

                        setTimeout(function() {
                            submitButtonReceivable.removeAttribute('data-kt-indicator');
                            var formReceivableData = new FormData();
                            formReceivableData.append("_token", csrf_token);
                            formReceivableData.append("price", $('[name="recivablePrice"]').val());
                            formReceivableData.append("paymentDate", $('[name="paymentDate"]').val());
                            formReceivableData.append("note", $('[name="note"]').val());

                            $.ajax({
                                url: '/personel/adission/'+ adissionId +'/receivable',
                                type: "POST",
                                data: formReceivableData,
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
                                        submitButtonReceivable.disabled = false;
                                        if (res.status != "error"){
                                            formReceivable.reset(); // Reset formReceivable
                                            receivableModal.hide(); // Hide modal

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

        cancelButtonReceivable.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                text: "Alacak Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
                icon: "warning",
                showcancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Evet, İptal Et!",
                submitButtonReceivableText: "Hayır, Devam Et",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    formReceivable.reset(); // Reset formReceivable
                    receivableModal.hide(); // Hide modal
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
                text: "Alacak Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
                icon: "warning",
                showcancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Evet, İptal Et!",
                cancelButtonText: "Hayır, Devam Et",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    formReceivable.reset(); // Reset formReceivable
                    receivableModal.hide(); // Hide receivableModal
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
            receivableModal = new bootstrap.Modal(document.querySelector('#kt_modal_add_receivable'));
            formReceivable = document.querySelector('#kt_modal_add_receivable_form');
            submitButtonReceivable = formReceivable.querySelector('#kt_modal_add_receivable_submit');
            cancelButtonReceivable = formReceivable.querySelector('#kt_modal_add_receivable_cancel');
            closeButtonPayment = formReceivable.querySelector('#kt_modal_add_receivable_close')
            handleformReceivable();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalReceivableAdd.init();
});
