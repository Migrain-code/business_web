"use strict";

// Class definition
var KTModalAppointmentCloseAdd = function () {
    var submitButton;
    var validator;
    var form;
    var modal;
    var appointmentTypeId;

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
                                var personelId = $('[name="personel_id_close"]').val();
                                var roomId;
                                var start_time;

                                if ($('[name="room_id_close"]').is(':radio')) {
                                    roomId = $('[name="room_id_close"]:checked').val();
                                } else {
                                    roomId = $('[name="room_id_close"]').val();
                                }
                                if ($('[name="start_time_close"]').is(':radio')) {
                                    start_time = $('[name="start_time_close"]:checked').val();

                                } else {
                                    start_time = $('[name="start_time_close"]').val();

                                }

                                submitButton.removeAttribute('data-kt-indicator');
                                var formData = new FormData();
                                formData.append("_token", csrf_token);
                                formData.append("customer_id", $('[name="customer_id_close"]').val());
                                formData.append("personel_id", personelId);
                                formData.append("appointment_date", $('[name="appointment_date_close"]').val());
                                formData.append("start_time", start_time);
                                formData.append("end_time", $('[name="end_time"]').val());
                                if (!isNaN(roomId)){
                                    formData.append("room_id", roomId);
                                }

                                formData.append("appointment_type", appointmentTypeId);
                                $('[name="service_id_close[]"] option:selected').each(function() {
                                    formData.append("service_id[]", $(this).val());
                                });
                            $.ajax({
                                url: '/isletme/speed-appointment/create/'+ personelId,
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
                                    });

                                    submitButton.disabled = false;
                                    if (res.status == "success"){
                                        form.reset(); // Reset form
                                        modal.hide(); // Hide modal

                                        $('#clockContainer').text("");
                                        $('#service_select').empty();
                                        $('#personel_select').val(null).trigger('change');
                                        $('#customer_select').empty();

                                        if ($.fn.DataTable.isDataTable('#datatable')) {
                                            $('#datatable').DataTable().ajax.reload();
                                        }
                                    }
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


    }

    return {
        // Public functions
        init: function () {
            // Elements
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_appointment_close'));
            form = document.querySelector('#kt_modal_add_appointment_form_close');
            submitButton = form.querySelector('#kt_modal_add_appointment_submit_close');
            appointmentTypeId = "closeClock";
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalAppointmentCloseAdd.init();
});
