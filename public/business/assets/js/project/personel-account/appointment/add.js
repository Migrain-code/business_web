"use strict";

// Class definition
var KTModalAppointmentAdd = function () {
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
                    'customer_id': {
                        validators: {
                            notEmpty: {
                                message: 'Müşteri Alanı Gereklidir'
                            }
                        }
                    },
                    'personel_id': {
                        validators: {
                            notEmpty: {
                                message: 'Personel Alanı Gereklidir'
                            }
                        }
                    },

                    'service_id[]': {
                        validators: {
                            notEmpty: {
                                message: 'Hizmet Seçimi Alanı Gereklidir'
                            }
                        }
                    },
                    'appointment_date': {
                        validators: {
                            notEmpty: {
                                message: 'Randevu Tarihi Alanı Gereklidir'
                            }
                        }
                    },
                    'start_time': {
                        validators: {
                            notEmpty: {
                                message: 'Randevu Başlangıç Saati Gereklidir'
                            }
                        }
                    },
                    'end_time': {
                        validators: {
                            notEmpty: {
                                message: 'Randevu Bitiş Saati Gereklidir'
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

        // Revalidate country field. For more info, plase visit the official plugin site: https://select2.org/
        $(form.querySelector('[name="city_id"]')).on('city_id', function() {
            // Revalidate the field when an option is chosen
            validator.revalidateField('city_id');
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
                            var formData = new FormData();
                            formData.append("_token", csrf_token);
                            formData.append("customer_id", $('[name="customer_id"]').val());
                            formData.append("personel_id", $('[name="personel_id"]').val());
                            formData.append("appointment_date", $('[name="appointment_date"]').val());
                            formData.append("start_time", $('[name="start_time"]').val());
                            formData.append("end_time", $('[name="end_time"]').val());
                            $('[name="service_id[]"] option:selected').each(function() {
                                formData.append("service_id[]", $(this).val());
                            });
                            $.ajax({
                                url: '/personel/speed-appointment/create',
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: "JSON",
                                success: function (res) {
                                    submitButton.disabled = false;
                                    Swal.fire({
                                        text: res.message,
                                        icon: res.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Tamam",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        submitButton.disabled = false;
                                        if (res.status == "success"){
                                            form.reset(); // Reset form
                                            modal.hide(); // Hide modal

                                            if ($.fn.DataTable.isDataTable('#datatable')) {
                                                $('#datatable').DataTable().ajax.reload();
                                            }
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
                text: "Randevu Oluştuma İşlemini İptal Etmek İstediğinize Eminmisiniz?",
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
                text: "Randevu Oluştuma İşlemini İptal Etmek İstediğinize Eminmisiniz?",
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
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_appointment'));

            form = document.querySelector('#kt_modal_add_appointment_form');
            submitButton = form.querySelector('#kt_modal_add_appointment_submit');
            cancelButton = form.querySelector('#kt_modal_add_appointment_cancel');
            closeButton = form.querySelector('#kt_modal_add_appointment_close');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalAppointmentAdd.init();
});
