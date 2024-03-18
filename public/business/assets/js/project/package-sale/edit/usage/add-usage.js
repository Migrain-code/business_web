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
                    'package_sale_id': {
                        validatorUsages: {
                            notEmpty: {
                                message: 'Paket Satışı Alanı Gereklidir'
                            }
                        }
                    },
                    'payment_price': {
                        validatorUsages: {
                            notEmpty: {
                                message: 'Fiyat Alanı Gereklidir'
                            }
                        }
                    },
                    'payment_amount': {
                        validatorUsages: {
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
                            formData.append("amount", $('[name="usage_amount"]').val());
                            formData.append("operation_date", $('[name="usage_date"]').val());
                            formData.append("personel_id", $('[name="usage_personel_id"]').val());

                            $.ajax({
                                url: '/isletme/package-sale/'+ packageSaleId+'/add-usage',
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
                                        submitButtonUsage.disabled = false;
                                        if (res.status != "error"){
                                            formUsage.reset(); // Reset formUsage
                                            modal.hide(); // Hide modal
                                            $('.usages').click();
                                            if (result.isConfirmed) {
                                                $('.usages').click();
                                                // Enable submit button after loading

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

        cancelButtonUsage.addEventListener('click', function (e) {
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
                    formUsage.reset(); // Reset form
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

        closeButtonUsage.addEventListener('click', function(e){
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
                    formUsage.reset(); // Reset form
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
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_usage'));

            formUsage = document.querySelector('#kt_modal_add_customer_usage');
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
