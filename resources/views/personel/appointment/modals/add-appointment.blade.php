<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_modal_add_appointment" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_add_appointment_form" data-kt-redirect="../../customers/list.html">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_appointment_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Randevu Oluştur</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_appointment_close" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                        @if($rooms->count() > 0)
                            <div data-kt-buttons="true" class="row">
                                <div class="col-lg-6 col-12">
                                    <!--begin::Salon Default-->
                                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5" style="min-width: 200px">
                                        <!--end::Description-->
                                        <div class="d-flex align-items-center me-2">
                                            <!--begin::Radio-->
                                            <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input roomCheckBox" data-discount="0" type="radio" checked name="room_id" value="0"/>
                                            </div>
                                            <!--end::Radio-->

                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    Salon
                                                </h2>
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Description-->
                                    </label>
                                    <!--end::Radio button-->
                                </div>
                                @foreach($rooms as $room)
                                    <div class="col-lg-6 col-12">
                                        <!--begin::Radio button-->
                                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5" style="min-width: 200px">
                                            <!--end::Description-->
                                            <div class="d-flex align-items-center me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                    <input class="form-check-input roomCheckBox" type="radio" @checked($room->is_main == 1) name="room_id" value="{{$room->id}}" data-discount="{{$room->price}}"/>
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Info-->
                                                <div class="flex-grow-1">
                                                    <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                        {{$room->name}}
                                                    </h2>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <!--end::Radio button-->
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Radio group-->
                        @else
                            <input type="hidden" name="room_id" value="">
                        @endif
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">

                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Müşteri Seçimi</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
                            </label>
                            <!--end::Label-->
                            <div class="d-flex gap-2 align-items-center">
                                <!--begin::Input-->
                                <select id="customer_select" placeholder="Müşteri Adı" style="" name="customer_id">
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
                            <select name="personel_id" id="personel_select" aria-label="Personel Seçiniz" data-control="select2" data-placeholder="Personel Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment" class="form-select form-select-solid fw-bold">
                                <option value="">Personel Seçiniz</option>

                            </select>
                        </div>
                        <!--end::Input group-->
                    <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmet Seçiniz</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi işlemi/işlemleri yapacak"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="service_id[]" id="service_select" multiple aria-label="Hizmet Seçiniz" data-control="select2" data-placeholder="Hizmet Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment" class="form-select form-select-solid fw-bold">
                                <option value="">Hizmet Seçiniz</option>

                            </select>
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Tarih Seçiniz</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" class="form-control form-control-solid" id="date_select" placeholder="" name="appointment_date" min="{{now()->toDateString()}}" value="" />
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
                                <select name="start_time" id="start_time_select" aria-label="Saat Seçiniz" data-control="select2" data-placeholder="Saat Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment" class="form-select form-select-solid fw-bold clockSelect">
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
                                <select name="end_time" id="end_time_select" aria-label="Saat Seçiniz" data-control="select2" data-placeholder="Saat Seçiniz..." data-dropdown-parent="#kt_modal_add_appointment" class="form-select form-select-solid fw-bold clockSelect">
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
                    <button type="reset" id="kt_modal_add_appointment_cancel" class="btn btn-light me-3">İptal Et</button>
                    <!--end::Button-->
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
