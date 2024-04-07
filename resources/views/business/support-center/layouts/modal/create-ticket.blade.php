<!--begin::Modal - Support Center - Create Ticket-->
<div class="modal fade" id="kt_modal_new_ticket" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                            class="path2"></span></i></div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                <!--begin:Form-->
                <form id="kt_modal_new_ticket_form" class="form" action="#">
                    <!--begin::Heading-->
                    <div class="mb-13 text-center">
                        <!--begin::Title-->
                        <h1 class="mb-3">Destek Talebi Oluştur</h1>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <div class="text-gray-400 fw-semibold fs-5">
                            Sorununuz acil ise acil çağrı merkezini
                            <a href="tel: +90 555 555 5555" class="fw-bold link-primary">
                                Arayabilirsiniz
                            </a>.
                        </div>
                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <!--begin::Col-->
                        <div class="col-md-12 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Konu</label>

                            <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Konu Seçiniz" name="why_is_it">
                                <option value="">Sebep Seçiniz...</option>
                                <option value="1">İşlem Yapamıyorum</option>
                                <option value="2">Kasma Yaşanıyor</option>
                                <option value="3">Sayfa Yüklenmiyor</option>
                                <option value="4">Hesaplamada Hata Var</option>
                                <option value="5">Belirli Alanın Kullanımı Anlamadım</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row g-9 mb-8">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Sorununuzun Aciliyet Durumu</label>

                            <select class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Seçiniz" data-hide-search="true" name="is_important">
                                <option value=""></option>
                                <option value="1" selected="">Çok Acil</option>
                                <option value="2">Biraz Bekleyebilirim</option>
                                <option value="3">Aciliyeti Yok</option>
                            </select>
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">
                                Tarih/Saat
                                <span class="ms-2" data-bs-toggle="tooltip"
                                      title="Sorunu Yaşadığınızı Tarihi ve saati seçiniz">
                                    <i class="ki-duotone ki-information fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </label>

                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center">
                                <!--begin::Icon-->
                                <div class="symbol symbol-20px me-4 position-absolute ms-4">
                                    <span class="symbol-label bg-secondary">
                                        <i class="ki-duotone ki-element-11">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Datepicker-->
                                <input class="form-control form-control-solid ps-12" placeholder="Tarih ve saat Seçiniz" name="due_date">
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="fs-6 fw-semibold mb-2">Açıklama</label>
                        <!--begin::Editor-->
                        <div id="kt_forms_widget_1_editor" class="py-6"></div>
                        <!--end::Editor-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="mb-15 fv-row">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack">
                            <!--begin::Label-->
                            <div class="fw-semibold me-5">
                                <label class="fs-6">Bildirimler</label>

                                <div class="fs-7 text-gray-400">Sorunuz Cevaplandığında Sizinle Nasıl İletişime Geçelim</div>
                            </div>
                            <!--end::Label-->

                            <!--begin::Checkboxes-->
                            <div class="d-flex align-items-center">
                                <!--begin::Checkbox-->
                                <label class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-20px" type="radio"
                                           name="notifications" value="E-posta">

                                    <span class="form-check-label fw-semibold">
                                        E-posta
                                    </span>
                                </label>
                                <!--end::Checkbox-->

                                <!--begin::Checkbox-->
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input h-20px w-20px" checked type="radio"
                                           name="notifications" value="Telefon">


                                    <span class="form-check-label fw-semibold">
                                        Telefon
                                    </span>
                                </label>
                                <!--end::Checkbox-->
                            </div>
                            <!--end::Checkboxes-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="reset" id="kt_modal_new_ticket_cancel" class="btn btn-light me-3">
                            İptal
                        </button>

                        <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                            <span class="indicator-label">
                                Gönder
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end:Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Support Center - Create Ticket-->
