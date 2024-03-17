"use strict";

// Fonksiyon tanımlaması
function initEcommerceSalesSaveOrder() {
    // Değişkenlerin tanımlanması
    var productTable, dataTable, searchFilter, selectedProducts, totalPrice, form, submitButton;

    // Formun doğrulanması ve gönderilmesi
    form = document.getElementById("kt_edit_package_sale_form");
    submitButton = document.getElementById("kt_ecommerce_edit_order_submit");
    var formValidation = FormValidation.formValidation(form, {
        fields: {
            'customer_id': {
                validators: {
                    notEmpty: {
                        message: 'Müşteri Seçimi Alanı Gereklidir'
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
            'personel_id': {
                validators: {
                    notEmpty: {
                        message: 'Personel Seçimi Alanı Gereklidir'
                    }
                }
            },
            'type_id': {
                validators: {
                    notEmpty: {
                        message: 'Hizmet Türü Seçimi Alanı Gereklidir'
                    }
                }
            },
            'amount': {
                validators: {
                    notEmpty: {
                        message: 'Adet Alanı Gereklidir'
                    }
                }
            },
            'price': {
                validators: {
                    notEmpty: {
                        message: 'Toplam Tutar Alanı Gereklidir'
                    }
                }
            },
            'seller_date': {
                validators: {
                    notEmpty: {
                        message: 'Satış Tarihi Alanı Gereklidir'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "",
                eleValidClass: ""
            })
        }
    });

    // Form gönderim butonunun tıklanma olayı
    submitButton.addEventListener("click", function (event) {
        event.preventDefault();
        formValidation && formValidation.validate().then(function (status) {
            if (status === "Valid") {
                submitButton.setAttribute("data-kt-indicator", "on");
                submitButton.disabled = true;
                setTimeout(function () {
                    submitButton.removeAttribute('data-kt-indicator');
                    var formData = new FormData();
                    formData.append("_token", csrf_token);
                    formData.append("_method", 'PUT');

                    formData.append("customer_id", $('[name="customer_id"]').val());
                    formData.append("personel_id", $('[name="personel_id"]').val());
                    formData.append("service_id", $('[name="service_id"]').val());
                    formData.append("type_id", $('[name="type_id"]').val());
                    formData.append("amount", $('[name="amount"]').val());
                    formData.append("price", $('[name="price"]').val());
                    formData.append("seller_date", $('[name="seller_date"]').val());

                    $.ajax({
                        url: '/isletme/package-sale/'+ packageSaleId,
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

                               window.location = form.getAttribute("data-kt-redirect");
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
