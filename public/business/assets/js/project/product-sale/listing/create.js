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

    // Arama filtresinin eşleşen ürünleri göstermek için DataTable'a uygulanması
    searchFilter = document.querySelector('[data-kt-ecommerce-edit-order-filter="search"]');
    searchFilter.addEventListener("keyup", function (event) {
        dataTable.search(event.target.value).draw();
    });

    // Seçilen ürünlerin ve toplam fiyatın güncellenmesi
    selectedProducts = document.getElementById("kt_ecommerce_edit_order_selected_products");
    totalPrice = document.getElementById("kt_ecommerce_edit_order_total_price");
    var checkboxes = productTable.querySelectorAll('[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function (event) {
            var selectedProduct = event.target.closest("tr").querySelector('[data-kt-ecommerce-edit-order-filter="product"]').cloneNode(true);

            var productDiv = document.createElement("div");
            var productContent = selectedProduct.innerHTML;
            var classesToRemove = ["d-flex", "align-items-center"];
            selectedProduct.classList.remove(...classesToRemove);
            selectedProduct.classList.add("col", "my-2");
            selectedProduct.innerHTML = "";
            productDiv.classList.add(...classesToRemove, "border", "border-dashed", "rounded", "p-3", "bg-body");
            productDiv.innerHTML = productContent;
            selectedProduct.appendChild(productDiv);
            var productId = selectedProduct.getAttribute("data-kt-ecommerce-edit-order-id");
            var qtyElement = selectedProduct.querySelector('[data-kt-ecommerce-edit-order-filter="qty"]');
            qtyElement.style.display = "block";
            qtyElement.name="qty_cart[]";
            // Yeni bir input oluştur ve product_id[] adını ver
            var productIdInput = document.createElement("input");
            productIdInput.type = "hidden";
            productIdInput.name = "product_id[]";
            productIdInput.value = productId;
            selectedProduct.appendChild(productIdInput);
            if (event.target.checked) {
                selectedProducts.appendChild(selectedProduct);
            } else {
                var existingProduct = selectedProducts.querySelector('[data-kt-ecommerce-edit-order-id="' + productId + '"]');
                if (existingProduct) {
                    selectedProducts.removeChild(existingProduct);
                }
            }
            updateTotalPrice();
            selectInputs();
        });
    });
    var inputs;
    function selectInputs(){
        inputs = document.querySelectorAll('input[name="qty_cart[]"]');

        inputs.forEach(function(input) {
            // Input değeri değiştiğinde alert göster
            input.addEventListener('input', function() {
                updateTotalPrice();
            });
        });
    }
    // Toplam fiyatı güncelleyen fonksiyon
    function updateTotalPrice() {
        var total = 0;
        var productElements = selectedProducts.querySelectorAll('[data-kt-ecommerce-edit-order-filter="product"]');

        productElements.forEach(function (element) {
            var price = parseFloat(element.querySelector('[data-kt-ecommerce-edit-order-filter="price"]').innerText);
            var qty = element.querySelector('[data-kt-ecommerce-edit-order-filter="qty"]').value;
            total += (price * qty);

        });
        totalPrice.innerText = total.toFixed(2);
    }
    selectedProducts.querySelectorAll('[data-kt-ecommerce-edit-order-filter="qty"]').forEach(function (qtyInput) {
        qtyInput.addEventListener('change', function () {
            // Find the parent product element
            var productElement = this.closest('[data-kt-ecommerce-edit-order-filter="product"]');
            // Update the total price for this specific product
            console.log(productElement);
        });
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
                    formData.append("note", $('[name="note"]').val());
                    formData.append("discount", $('[name="discount').val());
                    if (inputs.length > 0) {
                        inputs.forEach(function(input) {
                            formData.append(input.name, input.value);
                        });
                    }

                    var productIdInputs = document.querySelectorAll('input[name="product_id[]"]');
                    if (productIdInputs.length > 0) {
                        // If elements exist, append each one's value
                        productIdInputs.forEach(function(input) {
                            formData.append(input.name, input.value);
                        });
                    }
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
                                form.reset(); // Reset form
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
