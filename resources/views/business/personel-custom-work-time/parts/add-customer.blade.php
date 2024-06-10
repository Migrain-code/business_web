<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_add_customer_form" data-kt-redirect="../../customers/list.html">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Özel Çalışma Saati Ekle</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                        <!--begin::İşlem Tarihi-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Başlangıç Tarihi
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Özel Çalışma Saatleri Ne zaman bitecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid datePickerInput" id="" placeholder="" name="start_date" value="" />
                            <!--end::Input-->
                        </div>

                        <!--begin::İşlem Tarihi-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Bitiş Tarihi
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Özel Çalışma Saatleri Ne zaman bitecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid datePickerInput" id="datePickerInput2" placeholder="" name="end_date" value="" />
                            <!--end::Input-->
                        </div>
                        <div class="d-flex gap-2">
                            <div class="d-flex flex-column mb-7 fv-row col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Mesai Başlangıç Saati</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="İşletme Hangi Saatte Açılacak"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="start_time" id="city_select" aria-label="Mesai Başlangıç Saati Seçiniz" data-control="select2" data-placeholder="Mesai Başlangıç Saati Seçiniz..." data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                    <option value="">Mesai Başlangıç Saati Seçiniz</option>
                                    @for($i = now()->startOfDay(); $i < now()->endOfDay(); $i->addMinutes(5))
                                        <option value="{{$i->format('H:i')}}" @selected($i->format('H:i') == authUser()->business->start_time)>{{$i->format('H:i')}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="d-flex flex-column mb-7 fv-row col">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Mesai Bitiş Saati</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="İşletme Hangi Saatte Kapanacak"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="end_time" id="end_time" aria-label="Mesai Bitiş Saati Seçiniz" data-control="select2" data-placeholder="Mesai Bitiş Saati Seçiniz..." data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                    <option value="">Mesai Bitiş Saati Seçiniz</option>
                                    @for($i = now()->startOfDay(); $i < now()->endOfDay(); $i->addMinutes(5))
                                        <option value="{{$i->format('H:i')}}" @selected($i->format('H:i') == authUser()->business->end_time)>{{$i->format('H:i')}}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                        <div class="fv-row mb-7">
                            <div class="d-flex flex-column mb-7 fv-row">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Personeller</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Özel Çalışma Saatleri Hangi Personellere Uygulanacak"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="personels[]" id="personel_id" aria-label="Personelleri Seçiniz" multiple data-control="select2" data-placeholder="Personelleri Seçiniz..." data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                    <option value="">Personelleri Seçiniz</option>
                                    @foreach($personels as $personel)
                                        <option value="{{$personel->id}}">{{$personel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">İptal Et</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_add_customer_submit" class="btn btn-primary">
                        <span class="indicator-label">Kaydet</span>
                        <span class="indicator-progress">Lütfen Bekleyin...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->
