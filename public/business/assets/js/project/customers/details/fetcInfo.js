// Parapuan Liste
$('.cashPoint').on('click', function () {
    var customerId = $(this).data('customer');
    $.ajax({
        url: '/isletme/customer/' + customerId + '/cash-point-list',
        type: "GET",
        dataType: "JSON",
        success: function (response) {
            let container = document.getElementById('cashPointContainer');
            var items = "";
            if (response.length > 0){
                $.each(response, function (index, item) {
                    var item = `
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-5">
                        <!--begin::Flag-->
                        <i class="fa fa-ticket me-4 w-30px fs-1" style="transform: rotate(45deg);"></i>
                        <!--end::Flag-->

                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Randevu #${item.appointmentId}</a>
                            <!--end::Title-->

                            <!--begin::Desc-->
                            <span class="text-gray-400 fw-semibold fs-6 d-block text-start fw-bold ps-0">${item.created_at}</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Section-->

                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center">
                        <!--begin::Number-->
                        <span class="text-gray-800 fw-bold fs-4 me-3">${item.price} ₺</span>
                        <!--end::Number-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-4"></div>
                <!--end::Separator-->

               `;
                    items += item;
                });
            }
            else{
                items = `<div class="alert alert-warning d-flex align-items-center p-5 justify-content-center text-center">
                    <!--begin::Icon-->
                    <i class="ki-duotone ki-shield-tick fs-2hx text-warning me-4"><span class="path1"></span><span class="path2"></span></i>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Content-->
                        <span>Kayıt Bulunamadı.</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                `
            }
            container.innerHTML = items;
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                html: 'Sistemsel Bir Hata Sebebiyle Parapuan Listesi Alınamadı',
                buttonsStyling: false,
                confirmButtonText: "Tamam",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    });
});


