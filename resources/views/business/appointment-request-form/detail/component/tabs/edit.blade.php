<!--begin:::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_customer_general" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Form Bilgileri</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Form Başlığı
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu başlık sadece sizin panelinizde görüntülenecektir"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$requestForm->name}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Hizmetler-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Hizmetler</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Talep Formunuzda gösterilecek olan hizmetleri seçiniz"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="service_id[]" id="serviceIds" multiple aria-label="Hizmetleri Seçiniz" data-control="select2" data-placeholder="Hizmetleri Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_general" class="form-select form-select-solid fw-bold">
                        <option value="">Hizmetleri Seçiniz</option>
                        @foreach($businessServices as $service)
                            <option value="{{$service->id}}" @selected(in_array($service->id, $selectedBusinessServiceIds))>{{$service->subCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
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
