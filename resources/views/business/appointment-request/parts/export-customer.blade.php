<div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Rapor Oluştur</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div id="kt_customers_export_close"
                     class="btn btn-icon btn-sm btn-active-icon-primary">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                            class="path2"></span></i></div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_customers_export_form" class="form" action="#">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Select Export
                            Format:</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <select data-control="select2"
                                data-placeholder="Select a format" data-hide-search="true"
                                name="format" class="form-select form-select-solid">
                            <option value="excell">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="cvs">CVS</option>
                            <option value="zip">ZIP</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Select Date
                            Range:</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input class="form-control form-control-solid"
                               placeholder="Pick a date" name="date">
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Row-->
                    <div class="row fv-row mb-15">
                        <!--begin::Label-->
                        <label class="fs-5 fw-semibold form-label mb-5">Payment
                            Type:</label>
                        <!--end::Label-->

                        <!--begin::Radio group-->
                        <div class="d-flex flex-column">
                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="1"
                                       checked="checked" name="payment_type">
                                <span class="form-check-label text-gray-600 fw-semibold">
                                    All
                                </span>
                            </label>
                            <!--end::Radio button-->

                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="2"
                                       checked="checked" name="payment_type">
                                <span class="form-check-label text-gray-600 fw-semibold">
                                    Visa
                                </span>
                            </label>
                            <!--end::Radio button-->

                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox" value="3"
                                       name="payment_type">
                                <span class="form-check-label text-gray-600 fw-semibold">
                                    Mastercard
                                </span>
                            </label>
                            <!--end::Radio button-->

                            <!--begin::Radio button-->
                            <label class="form-check form-check-custom form-check-sm form-check-solid">
                                <input class="form-check-input" type="checkbox" value="4"
                                       name="payment_type">
                                <span class="form-check-label text-gray-600 fw-semibold">
                                    American Express
                                </span>
                            </label>
                            <!--end::Radio button-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_customers_export_cancel"
                                class="btn btn-light me-3">
                            Discard
                        </button>

                        <button type="submit" id="kt_customers_export_submit"
                                class="btn btn-primary">
                            <span class="indicator-label">
                                Submit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
