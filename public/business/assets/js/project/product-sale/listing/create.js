"use strict";

// Fonksiyon tanımlaması
function initEcommerceSalesSaveOrder() {
    // Değişkenlerin tanımlanması
    var productTable, dataTable, searchFilter, selectedProducts, totalPrice, form, submitButton;

    // Ürün tablosunun flatpickr ile ayarlanması
    $("#kt_ecommerce_edit_order_date").flatpickr({
        altInput: true,
        altFormat: "d F, Y H:i", // Saat bilgisini de içer
        dateFormat: "Y-m-d H:i", // Tarih ve saat formatını belirle
        enableTime: true, // Saat seçicisini etkinleştir
        time_24hr: true, // 24 saat formatını kullan
        locale: 'tr',
    });
    // Ürün tablosunun DataTable ile ayarlanması
    productTable = document.querySelector("#kt_ecommerce_edit_order_product_table");
    dataTable = $(productTable).DataTable({
        order: [],
        scrollCollapse: true,
        language: {
            "url": "https://cdn.datatables.net/plug-ins/1.11.2/i18n/tr.json"
        },
        paging: true,
        info: false,
        columnDefs: [{
            orderable: false,
            targets: 0
        }]
    });

    // Formun doğrulanması ve gönderilmesi
    form = document.getElementById("kt_ecommerce_edit_order_form");
    submitButton = document.getElementById("kt_ecommerce_edit_order_submit");
    var formValidation = FormValidation.formValidation(form, {
        fields: {
            payment_type: {
                validators: {
                    notEmpty: {
                        message: "Ödeme Türü Gereklidir"
                    }
                }
            },
            personel_id: {
                validators: {
                    notEmpty: {
                        message: "Personel Seçimi Gereklidir"
                    }
                }
            },
            customer_id: {
                validators: {
                    notEmpty: {
                        message: "Müşteri Seçimi Gereklidir"
                    }
                }
            },
            product_id: {
                validators: {
                    notEmpty: {
                        message: "Ürün Seçimi Gereklidir"
                    }
                }
            },
            seller_date: {
                validators: {
                    notEmpty: {
                        message: "İşlem Yapılan Tarih Gereklidir"
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
                    formData.append("payment_type", $('[name="payment_type"]').val());
                    formData.append("personel_id", $('[name="personel_id"]').val());
                    formData.append("customer_id", $('[name="customer_id"]').val());
                    formData.append("seller_date", $('[name="seller_date"]').val());
                    formData.append("amount", $('[name="amount"]').val());
                    formData.append("price", $('[name="price"]').val());
                    formData.append("product_id", $('[name="product_id"]').val());
                    formData.append("note", $('[name="note"]').val());
                    formData.append("discount", $('[name="discount').val());

                    $.ajax({
                        url: '/isletme/sale',
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
                                if (res.status == "success"){
                                    form.reset(); // Reset form
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
