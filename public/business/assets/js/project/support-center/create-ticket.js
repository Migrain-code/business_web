"use strict";

document.addEventListener("DOMContentLoaded", function () {
    var modal = document.querySelector("#kt_modal_new_ticket");
    if (!modal) return;

    var modalInstance = new bootstrap.Modal(modal);
    var form = document.getElementById("kt_modal_new_ticket_form");
    var submitBtn = document.getElementById("kt_modal_new_ticket_submit");
    var cancelBtn = document.getElementById("kt_modal_new_ticket_cancel");

    flatpickr(form.querySelector('[name="due_date"]'), {
        enableTime: true,
        dateFormat: "d.M.Y H:i"
    });

    var formValidator = FormValidation.formValidation(form, {
        fields: {
            subject: { validators: { notEmpty: { message: "Ticket subject is required" } } },
            user: { validators: { notEmpty: { message: "Ticket user is required" } } },
            due_date: { validators: { notEmpty: { message: "Ticket due date is required" } } },
            description: { validators: { notEmpty: { message: "Target description is required" } } },
            notifications: { validators: { notEmpty: { message: "Please select at least one notifications method" } } }
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

    submitBtn.addEventListener("click", function (event) {
        event.preventDefault();
        formValidator.validate().then(function (status) {
            var content = quill.root.innerHTML;

            var formData = new FormData();
            formData.append("_token", csrf_token);
            formData.append("why_is_it", $('[name="why_is_it"]').val());
            formData.append("due_date", $('[name="due_date"]').val());
            formData.append("notifications", $('[name="notifications"]').val());
            formData.append("order_number", $('[name="is_important"]').val());
            formData.append("description", content);

            $.ajax({
                url: '/isletme/support-center',
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
                        modalInstance.hide();

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
        });
    });

    cancelBtn.addEventListener("click", function (event) {
        event.preventDefault();
        Swal.fire({
            text: "İptal Etmek İstediğinize Emin misiniz?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Evet, iptal et!",
            cancelButtonText: "Hayır, devam et",
            customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" }
        }).then(function (result) {
            if (result.value) {
                form.reset();
                modalInstance.hide();
            }
        });
    });
});
