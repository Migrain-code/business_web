<!--begin:::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_customer_general" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Masraf Bilgileri</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                <!--begin::Harcayan-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Harcayan</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masrafı Yapan Personel Kim"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="personel_id" id="personel_id" aria-label="Personel Seçiniz" data-control="select2" data-placeholder="Personel Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_general" class="form-select form-select-solid fw-bold">
                        <option value="">Personel Seçiniz</option>
                        @foreach($personels as $personel)
                            <option value="{{$personel->id}}" @selected($personel->id == $cost->personel_id)>{{$personel->name}}</option>
                        @endforeach
                    </select>
                </div>
                <!--begin::Masraf Kategorisi-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Masraf Kategorisi</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masraf Hangi Türde Yapıldı"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="category_id" id="category_id" aria-label="Masraf Kategorisi Seçiniz" data-control="select2" data-placeholder="Masraf Kategorisi Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_general" class="form-select form-select-solid fw-bold">
                        <option value="">Masraf Kategorisi Seçiniz</option>
                        @foreach($costCategories as $costCategory)
                            <option value="{{$costCategory->id}}" @selected($costCategory->id == $cost->cost_category_id)>{{$costCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <!--end::Input group-->
                <!--begin::Ödeme Yöntemi-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Ödeme Yöntemi</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masrafa Hangi Türde Ödeme Yapıldı"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="payment_id" id="payment_id" aria-label="Ödeme Yöntemi Seçiniz" data-control="select2" data-placeholder="Ödeme Yöntemi Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_general" class="form-select form-select-solid fw-bold">
                        <option value="">Ödeme Yöntemi Seçiniz</option>
                        @foreach($paymentTypes as $paymentType)
                            <option value="{{$paymentType["id"]}}" @selected($paymentType["id"] == $cost->payment_type_id)>{{$paymentType["name"]}}</option>
                        @endforeach
                    </select>
                </div>
                <!--begin::Tutar-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Tutar
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Ne kadar masraf yapıldı"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" class="form-control form-control-solid" placeholder="" name="price" value="{{$cost->price}}" />
                    <!--end::Input-->
                </div>
                <!--begin::İşlem Tarihi-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">İşlem Tarihi
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masrafın Yapıldığı Tarih"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" id="kt_ecommerce_edit_order_date" placeholder="" name="operation_date" value="{{$cost->operation_date}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Açıklama-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Açıklama</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masrafın Açıklaması."></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="description" value="{{$cost->description}}" />
                    <!--end::Input-->
                </div>
                <!--end::Not group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Not
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masrafa eklemek istediğiniz not varsa"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea type="text" class="form-control form-control-solid" placeholder="" name="note" rows="5">{{$cost->note}}</textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--end::Row-->
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_customer_profile_submit" class="btn btn-light-primary">
                        <span class="indicator-label">Kaydet</span>
                        <span class="indicator-progress">Kaydediliyor...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</div>
<!--end:::Tab pane-->
