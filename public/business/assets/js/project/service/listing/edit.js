"use strict";

// Fonksiyon tanımlaması
function initEcommerceSalesSaveOrder() {
    // Değişkenlerin tanımlanması
    var productTable, dataTable, searchFilter, selectedProducts, totalPrice, form, submitButton;

    // Formun doğrulanması ve gönderilmesi
    form = document.getElementById("kt_modal_add_customer");
    submitButton = document.getElementById("kt_ecommerce_edit_order_submit");
    var formValidation = FormValidation.formValidation(form,
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
                            message: 'Cinsiye Seçimi Alanı Gereklidir'
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
                'price': {
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

    // Form gönderim butonunun tıklanma olayı
    submitButton.addEventListener("click", function (event) {
        event.preventDefault();
        formValidation && formValidation.validate().then(function (status) {
            if (status === "Valid") {
                submitButton.setAttribute("data-kt-indicator", "on");
                submitButton.disabled = true;
                setTimeout(function () {
                    submitButton.removeAttribute('data-kt-indicator');
                    var selectedValue = $('input[name="type_id"]:checked').val();
                    var formData = new FormData();
                    formData.append("_token", csrf_token);
                    formData.append("_method", 'PUT');
                    formData.append("_token", csrf_token);
                    formData.append("typeId", selectedValue);
                    formData.append("categoryId", $('[name="category_id"]').val());
                    formData.append("subCategoryId", $('[name="service_id"]').val());
                    formData.append("time", $('[name="time"]').val());
                    formData.append("price", $('[name="price"]').val());
                    $.ajax({
                        url: '/isletme/service/'+ serviceId,
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
                                confirmButtonText: "Tamam",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                submitButton.disabled = false;
                                if (res.status === "success"){
                                    window.location = form.getAttribute("data-kt-redirect");
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
                            submitButton.disabled = false;
                        }
                    });

                }, 2000);
            } else {
                Swal.fire({
                    html: "Zorunlu alanları doldurmanız gerekmektedir",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Tamam, anladım!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    });
}

// DOM içeriği tamamen yüklendiğinde fonksiyonun çağrılması
document.addEventListener("DOMContentLoaded", function () {
    initEcommerceSalesSaveOrder();
});
