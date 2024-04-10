<!--begin:::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_customer_general" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Alacak Bilgileri</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                <!--begin::Harcayan-->
                <!--begin::Harcayan-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Müşteri</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Müşteri Seçiniz"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="customer_id" id="personel_id" aria-label="Müşteri Seçiniz" data-control="select2" data-placeholder="Müşteri Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_profile" class="form-select form-select-solid fw-bold">
                        <option value="">Müşteri Seçiniz</option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->customer->id}}" @selected($receivable->customer_id == $customer->customer->id)>{{$customer->customer->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Tutar
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Ne kadar tutar alınacak"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" class="form-control form-control-solid" placeholder="" name="price" value="{{$receivable->price}}" />
                    <!--end::Input-->
                </div>
                <!--begin::İşlem Tarihi-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">İşlem Tarihi
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Ödeme Tarihi"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" id="kt_ecommerce_edit_order_date" placeholder="" name="operation_date" value="{{$receivable->payment_date}}" />
                    <!--end::Input-->
                </div>

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Not
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Masrafa eklemek istediğiniz not varsa"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea type="text" class="form-control form-control-solid" placeholder="" name="note" rows="5">{{$receivable->note}}</textarea>
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
