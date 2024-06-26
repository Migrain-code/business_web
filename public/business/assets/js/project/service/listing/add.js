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
                    'category_id': {
                        validators: {
                            notEmpty: {
                                message: 'Kategori Seçimi Alanı Gereklidir'
                            }
                        }
                    },
                    'service_id': {
                        validators: {
                            notEmpty: {
                                message: 'Hizmet Seçimi Alanı Gereklidir'
                            }
                        }
                    },
                    'type_id': {
                        validators: {
                            notEmpty: {
                                message: 'Cinsiyet Seçimi Alanı Gereklidir'
                            }
                        }
                    },
                    'approve_type': {
                        validators: {
                            notEmpty: {
                                message: 'Onay Türü Alanı Gereklidir'
                            }
                        }
                    },
                    'time': {
                        validators: {
                            notEmpty: {
                                message: 'Hizmet Süresi Alanı Gereklidir'
                            }
                        }
                    },

                    'price_type_id': {
                        validators: {
                            notEmpty: {
                                message: 'Fiyat Türü Alanı Gereklidir'
                            }
                        }
                    },
                    'price': {
                        validators: {
                            notEmpty: {
                                message: 'Fiyat Alanı Gereklidir'
                            },
                            enabled: false // Başlangıçta devre dışı bırakıldı
                        }
                    },
                    'min_price': {
                        validators: {
                            notEmpty: {
                                message: 'Minimum Fiyat Alanı Gereklidir'
                            },
                            enabled: false // Başlangıçta devre dışı bırakıldı
                        }
                    },
                    'max_price': {
                        validators: {
                            notEmpty: {
                                message: 'Maksimum Fiyat Alanı Gereklidir'
                            },
                            enabled: false // Başlangıçta devre dışı bırakıldı
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

        form.querySelector('[name="price_type_id"]').addEventListener('change', function() {
            var priceTypeId = this.value;

            // Fiyat türü 2 ise, min_price ve max_price alanlarını zorunlu yap
            if (priceTypeId === '1') {
                validator.enableFieldValidators('min_price', true);
                validator.enableFieldValidators('max_price', true);
                validator.disableFieldValidators('price', true);
            } else {
                // Fiyat türü 2 değilse, price alanını zorunlu yap
                validator.enableFieldValidators('price', true);
                validator.disableFieldValidators('min_price', true);
                validator.disableFieldValidators('max_price', true);
            }
        });
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
                            var selectedValue = $('input[name="type_id"]:checked').val();
                            var selectedApproveType = $('input[name="approve_type"]:checked').val();
                            var formData = new FormData();
                            formData.append("_token", csrf_token);
                            formData.append("typeId", selectedValue);
                            formData.append("approve_type", selectedApproveType);
                            formData.append("categoryId", $('[name="category_id"]').val());
                            formData.append("subCategoryId", $('[name="service_id"]').val());
                            formData.append("time", $('[name="time"]').val());
                            formData.append("price", $('[name="price"]').val());
                            formData.append("min_price", $('[name="min_price"]').val());
                            formData.append("max_price", $('[name="max_price"]').val());
                            formData.append("price_type_id", selectedPriceType);

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
                                        confirmButtonText: "Tamam, Devam Et!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        form.reset(); // Reset form
                                        modal.hide(); // Hide modal
                                        submitButton.disabled = false;
                                        if ($.fn.DataTable.isDataTable('#datatable')) {
                                            $('#datatable').DataTable().ajax.reload();
                                        }
                                        if (result.isConfirmed) {

                                            // Enable submit button after loading

                                            // Redirect to customers list page
                                            //window.location = form.getAttribute("data-kt-redirect");
                                        }
                                    });

                                },
                                error: function (xhr) {
                                    submitButton.disabled = false;
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
                text: "Paket Satışı Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
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
                text: "Paket Satışı Ekleme İşlemini İptal Etmek İstediğinize Eminmisiniz?",
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
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_customer'));

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
