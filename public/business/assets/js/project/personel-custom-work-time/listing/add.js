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
                    'start_date': {
                        validators: {
                            notEmpty: {
                                message: 'Başlangıç Tarihi Alanı Gereklidir'
                            },
                        }
                    },
                    'end_date': {
                        validators: {
                            notEmpty: {
                                message: 'Bitiş Tarihi Alanı Gereklidir'
                            },
                        }
                    },
                    'start_time': {
                        validators: {
                            notEmpty: {
                                message: 'Mesai Başlangıç Saati Alanı Gereklidir'
                            },
                        }
                    },
                    'end_time': {
                        validators: {
                            notEmpty: {
                                message: 'Mesai Bitiş Saati Alanı Gereklidir'
                            }
                        }
                    },
                    'personels[]': {
                        validators: {
                            notEmpty: {
                                message: 'Personeller Alanı Gereklidir'
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
        $(form.querySelector('[name="city_id"]')).on('city_id', function () {
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

                        setTimeout(function () {
                            submitButton.removeAttribute('data-kt-indicator');
                            var formData = new FormData();
                            formData.append("_token", csrf_token);
                            formData.append("start_time", $('[name="start_time"]').val());
                            formData.append("end_time", $('[name="end_time"]').val());
                            formData.append("start_date", $('[name="start_date"]').val());
                            formData.append("end_date", $('[name="end_date"]').val());

                            $('#personel_id option:selected').each(function () {
                                formData.append("personels[]", $(this).val());
                            });
                            $.ajax({
                                url: '/isletme/personel-custom-work-time',
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: "JSON",
                                success: function (res) {
                                    if (res.status == "success") {
                                        modal.hide(); // Hide modal
                                        $("#personel_id").prop("selectedIndex", -1).trigger("change");

                                    }
                                    Swal.fire({
                                        text: res.message,
                                        icon: res.status,
                                        buttonsStyling: false,
                                        confirmButtonText: "Tamam, devam et!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        submitButton.disabled = false;
                                        if (res.status == "success") {
                                            form.reset(); // Reset form


                                            if ($.fn.DataTable.isDataTable('#datatable')) {
                                                $('#datatable').DataTable().ajax.reload();
                                            }
                                            if (result.isConfirmed) {
                                                //tamam butonuna tıklandığında
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
            form.reset(); // Reset form
            modal.hide(); // Hide modal
        });

        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            form.reset(); // Reset form
            modal.hide(); // Hide modal

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
