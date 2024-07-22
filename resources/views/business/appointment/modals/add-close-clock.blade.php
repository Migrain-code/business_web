<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_modal_add_appointment_close" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_add_appointment_form_close">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_appointment_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Saat Kapatma</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <button type="button" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_appointment_close_app">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required">Müşteri Seçimi</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
                        </label>
                        <!--end::Label-->
                        <div class="d-flex gap-2 align-items-center">
                            <!--begin::Input-->
                            <select id="customer_select_close" placeholder="Müşteri Adı" style="" name="customer_id_close">
                                <option value="">Müşteri Ara</option>
                            </select>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" href="#kt_modal_add_customer"><i class="fa fa-plus-circle"></i></button>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required">Personel Seçiniz</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi Personel Hizmet Verecek"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="personel_id_close" id="personel_select_close" aria-label="Personel Seçiniz" data-control="select2" data-placeholder="Personel Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment_close" class="form-select form-select-solid fw-bold">
                            <option value="">Personel Seçiniz</option>
                            @foreach($personels as $personel)
                                <option value="{{$personel->id}}">{{$personel->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                    <div class="row" id="roomSelectAreaClose">

                    </div>
                    <div class="d-flex flex-column mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="required">Hizmet Seçiniz</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi işlemi/işlemleri yapacak"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select name="service_id_close[]" id="service_select_close" multiple aria-label="Hizmet Seçiniz" data-control="select2" data-placeholder="Hizmet Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment_close" class="form-select form-select-solid fw-bold">
                            <option value="">Hizmet Seçiniz</option>

                        </select>
                    </div>
                    <!--end::Input group-->
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Tarih Seçiniz</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control form-control-solid datePickerSelect" id="date_select_close" placeholder="" name="appointment_date_close" min="{{now()->toDateString()}}" value="" />
                        <!--end::Input-->
                    </div>

                    <div class="d-flex">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row w-50 me-2">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Başlangıç Saati</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Randevu Saat Kaçta Başlayacak"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="start_time_close" id="start_time_select_close" aria-label="Saat Seçiniz" data-control="select2" data-placeholder="Saat Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment_close" class="form-select form-select-solid fw-bold clockSelect">
                                <option value="">Saat Seçiniz</option>

                            </select>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row w-50">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Bitiş Saati</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Randevu Saat Kaçta Bitecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="end_time" id="end_time_select_close" aria-label="Saat Seçiniz" data-control="select2" data-placeholder="Saat Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment_close" class="form-select form-select-solid fw-bold clockSelect">
                                <option value="">Saat Seçiniz</option>

                            </select>
                        </div>
                        <!--end::Scroll-->
                    </div>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">

                    <!--begin::Button-->
                    <button type="submit" id="kt_modal_add_appointment_submit" class="btn btn-primary">
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
