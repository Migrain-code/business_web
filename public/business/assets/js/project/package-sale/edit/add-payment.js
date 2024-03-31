"use strict";

// Class definition
var KTModalCustomersAdd = function () {
    var submitButton;
    var cancelButton;
    var closeButton;
    var validator;
    var form;
    var modal;

    // Init form inputs
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'package_sale_id': {
                        validators: {
                            notEmpty: {
                                message: 'Paket Satışı Alanı Gereklidir'
                            }
                        }
                    },
                    'payment_price': {
                        validators: {
                            notEmpty: {
                                message: 'Fiyat Alanı Gereklidir'
                            }
                        }
                    },
                    'payment_amount': {
                        validators: {
                            notEmpty: {
                                message: 'Adet Alanı Gereklidir'
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
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {

                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        submitButton.disabled = true;

                        setTimeout(function() {
                            submitButton.removeAttribute('data-kt-indicator');
                            var formData = new FormData();
                            formData.append("_token", csrf_token);
                            formData.append("price", $('[name="payment_price"]').val());
                            formData.append("amount", $('[name="payment_amount"]').val());

                            $.ajax({
                                url: '/isletme/package-sale/'+ packageSaleId+'/add-payment',
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
                                        confirmButtonText: "Tamam, Devam Et!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        submitButton.disabled = false;
                                        if (res.status != "error"){
                                            form.reset(); // Reset form
                                            modal.hide(); // Hide modal
                                            $('.payments').click();
                                            if (result.isConfirmed) {
                                                $('.payments').click();
                                                // Enable submit button after loading
                                                window.location.reload();
                                                // Redirect to customers list page
                                                //window.location = form.getAttribute("data-kt-redirect");
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

        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                text: "Paket Ödemesi Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Evet, İptal Et!",
                cancelButtonText: "Hayır, Devam Et",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide(); // Hide modal
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

        closeButton.addEventListener('click', function(e){
            e.preventDefault();
            Swal.fire({
                text: "Paket Ödemesi Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Evet, İptal Et!",
                cancelButtonText: "Hayır, Devam Et",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form
                    modal.hide(); // Hide modal
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
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_payment'));

            form = document.querySelector('#kt_modal_add_customer_form');
            submitButton = form.querySelector('#kt_modal_add_customer_submit');
            cancelButton = form.querySelector('#kt_modal_add_customer_cancel');
            closeButton = form.querySelector('#kt_modal_add_customer_close');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalCustomersAdd.init();
});
