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
                    <h2 class="fw-bold">Hizmet Ekle</h2>
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
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Kategori Seçiniz</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi kategoride hizmet verilecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="category_id" id="category_select" aria-label="Kategori Seçiniz" data-control="select2" data-placeholder="Kategori Seçiniz..." data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Kategori Seçiniz</option>
                                @foreach($serviceCategories as $serviceCategorie)
                                    <option value="{{$serviceCategorie->id}}">{{$serviceCategorie->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmet Seçiniz</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi Hizmet Verilecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="service_id" id="service_select" aria-label="Hizmet Seçiniz" data-control="select2" data-placeholder="Hizmet Seçiniz..." data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Hizmet Seçiniz</option>

                            </select>
                        </div>

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Cinsiyet Seçiniz</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu paket hangi hizmet türünde verilecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="d-flex">
                                @foreach($typeList as $type)
                                    <div class="form-check form-check-custom form-check-solid form-check-lg me-2">
                                        <input class="form-check-input" @checked($typeList->count() == 1) name="type_id" type="radio" value="{{$type->id}}" id="flexCheckboxLg{{$type->id}}"/>
                                        <label class="form-check-label" for="flexCheckboxLg{{$type->id}}">
                                            {{$type->name}}
                                        </label>
                                    </div>

                                @endforeach

                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Onay Türü Seçiniz</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu hizmet otomatik onaylansın mı"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="d-flex">
                                <div class="form-check form-check-custom form-check-solid form-check-lg me-2">
                                    <input class="form-check-input" checked name="approve_type" type="radio" value="0" id="flexCheckboxLg0"/>
                                    <label class="form-check-label" for="flexCheckboxLg0">
                                        Otomatik Onay
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid form-check-lg me-2">
                                    <input class="form-check-input" name="approve_type" type="radio" value="1" id="flexCheckboxLg0"/>
                                    <label class="form-check-label" for="flexCheckboxLg0">
                                        Manuel Onay
                                    </label>
                                </div>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">İşlem Süresi</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Seçtiğiniz Hizmet Türüne Göre veri girebilirsiniz."></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" class="form-control form-control-solid" placeholder="Örn. 10" name="time" value="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Fiyat Türü Seçiniz</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu paket hangi hizmet türünde verilecek"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="d-flex">
                                    <div class="form-check form-check-custom form-check-solid form-check-lg me-2">
                                        <input class="form-check-input" name="price_type_id" type="radio" value="0" id="flexCheckboxLgType1"/>
                                        <label class="form-check-label" for="flexCheckboxLgType1">
                                            Tek Fiyat
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid form-check-lg me-2" >
                                        <input class="form-check-input" name="price_type_id" type="radio" value="1" id="flexCheckboxLgType2"/>
                                        <label class="form-check-label" for="flexCheckboxLgType2">
                                            Aralıklı Fiyat
                                        </label>
                                    </div>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7" id="singlePrice">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmet Fiyatı</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu hizmetin ücreti"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" class="form-control form-control-solid phone" placeholder="0.00" name="price" value="" />
                            <!--end::Input-->
                        </div>
                        <div class="fv-row mb-7" id="rangePrice" style="display: none">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmet Fiyat aralığı</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu hizmetin ücreti"></i>
                            </label>
                            <!--end::Label-->
                            <div class="d-flex">
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid me-2" placeholder="En Düşük Fiyat" name="min_price" value="" />
                                <!--end::Input-->
                                <!--begin::Input-->
                                <input type="number" class="form-control form-control-solid phone" placeholder="En Yüksek Fiyat" name="max_price" value="" />
                                <!--end::Input-->
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
