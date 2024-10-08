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
								message: 'Name is required'
							}
						}
					},
					'email': {
						validators: {
							notEmpty: {
								message: 'General Email is required'
							}
						}
					}
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
                            formData.append("email", $('[name="email"]').val());
                            formData.append("city_id", $('[name="city_id"]').val());
                            formData.append("district_id", $('[name="district_id"]').val());
                            formData.append("app_phone", $('[name="app_phone"]').val());
                            formData.append("gender", $('[name="gender"]').val());
                            formData.append("birthday", $('[name="birthday"]').val());
                            formData.append("profilePhoto", $('[name="avatar"]')[0].files[0]);
                            $.ajax({
                                url: '/isletme/customer/'+ customerId,
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
                                        if (result.isConfirmed) {
                                            submitButton.disabled = false;
                                        }
                                    });

                                },
                                error: function (xhr) {
                                    var errorMessage = "<ul>";
                                    submitButton.disabled = false;

                                    // Check if there's a responseJSON and a message in it
                                    if (xhr.status === 403) {
                                        errorMessage += "<li>Bu işlemi yapabilmek için yetkiniz bulunmuyor.</li>";
                                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMessage += "<li>" + xhr.responseJSON.message + "</li>";
                                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                        // If errors array exists, loop through it
                                        xhr.responseJSON.errors.forEach(function (error) {
                                            errorMessage += "<li>" + error + "</li>";
                                        });
                                    } else {
                                        // Default message in case response structure is different
                                        errorMessage += "<li>Bilinmeyen bir hata oluştu.</li>";
                                    }
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
                                    submitButton.disabled = false;
                                }
                            });
						}, 2000);
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
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
