<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_modal_add_service" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Hizmet Ekle</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Input group-->
                    <input type="hidden" name="service_id" value="">
                    <input type="hidden" name="category_id" value="">
                    <div class="fv-row row">
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="form-label mb-3">Fiyat
                                <span class="ms-1" data-bs-toggle="tooltip" title="Seçtiğiniz Hizmetin Fiyatı">
                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="number" class="form-control form-control-lg form-control-solid" name="price" placeholder="" value="">
                            <!--end::Input-->
                        </div>
                        <div class="col-12">
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="form-label mb-3">Süre
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Seçtiğiniz Hizmetin Süresi">
                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    </span>
                                </label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-lg form-control-solid" name="time" placeholder="" value="">
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="fw-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label required">Cinsiyet
                                <span class="ms-1" data-bs-toggle="tooltip" title="Bu hizmeti hangi cinsiyette vereceksiniz">
                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <select name="gender" class="form-select form-select-lg form-select-solid" data-control="select2"
                                    data-placeholder="Cinsiyet Seçiniz..." data-allow-clear="true" data-hide-search="true">
                                <option></option>

                                <option value="0">Kadın</option>
                                <option value="1">Erkek</option>
                                <option value="2">Kadın/Erkek</option>
                            </select>
                            <!--end::Input-->

                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" data-bs-dismiss="modal" class="btn btn-light me-3">İptal Et</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="kt_modal_add_service_submit" class="btn btn-primary">
                        <span class="indicator-label">Kaydet</span>
                        <span class="indicator-progress">Lütfen Bekleyin...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->
