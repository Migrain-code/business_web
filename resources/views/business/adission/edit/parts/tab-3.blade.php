<!--begin::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_adission_payment" role="tab-panel">
    <!--begin::Orders-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <!--begin::Order history-->
        <div class="card card-flush py-4 flex-row-fluid">
            <!--begin::Card header-->
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Adisyon Ödeme Detayı</h2>
                </div>
                <button type="button" class="btn btn-light-warning" onclick="fetchCashPointInfos()" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_cashpoint"><i class="fa fa-plus-circle me-2"></i>
                    Parapuan Kullan
                </button>

            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="row" id="printTable">
                    <div class="col-6">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">Toplam Tutar</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold fs-2">
                                    <b id="totalPayment"></b>
                                    <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                                    <div class="fs-7 fw-normal text-muted">Adisyondaki hizmetlerin ve ürünlerin toplam tutarı.</div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">Parapuan Kullanımı</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold fs-2">
                                    <b id="cashpoint"></b>
                                    <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                                    <div class="fs-7 fw-normal text-muted">Bu adisyonda kullanılan parapuan tutarı.</div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">Kampanya İndirimi</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold fs-2">
                                    <b id="campaignDiscount"></b>
                                    <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                                    <div class="fs-7 fw-normal text-muted">Bu adisyona uygulanan kampanya indirimi</div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">Tahsil Edilecek Tutar</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold fs-2">
                                    <b id="collectedTotal"></b>
                                    <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                                    <div class="fs-7 fw-normal text-muted">Adisyona indirim uygulanmış tutar.</div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2 class="fw-bold">Ödenecek Kalan Tutar</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold fs-2">
                                    <b id="remainingAmount"></b>
                                    <span class="text-muted fs-4 fw-semibold">Türk Lirası</span>
                                    <div class="fs-7 fw-normal text-muted">Adisyona yapılan toplam ödemelerin tutarı.</div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Order history-->

    </div>
    <!--end::Orders-->
</div>
<!--end::Tab pane-->
