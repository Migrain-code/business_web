"use strict";

// Class definition
var KTEcommerceUpdateProfile = function () {
    var submitButton;
    var validator;
    var form;

    // Init form inputs
    var handleForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Form Adı Alanı Gereklidir'
                            },
                        }
                    },
                    'service_id[]': {
                        validators: {
                            notEmpty: {
                                message: 'Hizmetler Alanı Gereklidir'
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
					console.log('validated!');

					if (status == 'Valid') {
						submitButton.setAttribute('data-kt-indicator', 'on');

						// Disable submit button whilst loading
						submitButton.disabled = true;

						setTimeout(function() {
							submitButton.removeAttribute('data-kt-indicator');

                            var formData = new FormData();
                            formData.append("_token", csrf_token);
                            formData.append("_method", "PUT");
                            formData.append("name", $('[name="name"]').val());
                            var selectedOptions = document.getElementById('serviceIds').selectedOptions;
                            for (var i = 0; i < selectedOptions.length; i++) {
                                formData.append('service_id[]', selectedOptions[i].value);
                            }
                            $.ajax({
                                url: updateUrl,
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
                                        confirmButtonText: "Tamam, devam et!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        submitButton.disabled = false;
                                        if (result.isConfirmed) {
                                            if (res.status == "success"){
                                                window.location.href = "/isletme/request-form";
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
							text: "Bazı Sorunlar oluştu bilgieri kontrol edip tekrar kaydediniz.",
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
            form = document.querySelector('#kt_ecommerce_customer_profile');
            submitButton = form.querySelector('#kt_ecommerce_customer_profile_submit');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTEcommerceUpdateProfile.init();
});
