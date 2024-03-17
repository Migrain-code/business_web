<!--begin::Aside column-->
<div class="w-100 flex-lg-row-auto w-lg-500px mb-7 me-7 me-lg-10">

    <!--begin::Order details-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Paket Satış Detayı</h2>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                <span class="indicator-label">
                    Güncelle
                </span>
                    <span class="indicator-progress">
                    Satış Güncelleniyor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="d-flex flex-column gap-3" id="kt_edit_package_sale_form" data-kt-redirect="{{route('business.package-sale.edit', $packageSale->id)}}">
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Müşteri Seçiniz</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Paket hangi müşteriye tanımlanacak"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="customer_id" id="city_select" aria-label="Müşteri Seçiniz" data-control="select2" data-placeholder="Müşteri Seçiniz..." data-dropdown-parent="#kt_ecommerce_edit_order_form" class="form-select form-select-solid fw-bold">
                        <option value="">Müşteri Seçiniz</option>
                        @foreach(authUser()->business->customers as $customer)
                            <option value="{{$customer->customer->id}}" @selected($customer->customer->id == $packageSale->customer_id)>{{$customer->customer->name}}</option>
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
                    <select name="service_id" id="service_select" aria-label="Hizmet Seçiniz" data-control="select2" data-placeholder="Hizmet Seçiniz..." data-dropdown-parent="#kt_ecommerce_edit_order_form" class="form-select form-select-solid fw-bold">
                        <option value="">Hizmet Seçiniz</option>
                        @foreach(authUser()->business->services as $service)
                            <option value="{{$service->id}}" @selected($service->id == $packageSale->service_id)>{{$service->subCategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Satıcı Seçiniz</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Satışı Yapan Personel"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="personel_id" id="personel_select" aria-label="Satıcı Seçiniz" data-control="select2" data-placeholder="Satıcı Seçiniz..." data-dropdown-parent="#kt_ecommerce_edit_order_form" class="form-select form-select-solid fw-bold">
                        <option value="">Satıcı Seçiniz</option>
                        @foreach(authUser()->business->personels as $personel)
                            <option value="{{$personel->id}}" @selected($personel->id == $packageSale->personel_id)>{{$personel->name}}</option>
                        @endforeach
                    </select>
                </div>
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Hizmet Türü</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu paket hangi hizmet türünde verilecek"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="d-flex">
                        <div class="form-check form-check-custom form-check-solid form-check-lg me-2">
                            <input class="form-check-input" name="type_id" @checked($packageSale->type == 0)  type="radio" value="0" id="flexCheckboxLg1"/>
                            <label class="form-check-label" for="flexCheckboxLg1">
                                Seans
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                            <input class="form-check-input" name="type_id" @checked($packageSale->type == 1) type="radio" value="1" id="flexCheckboxLg2"/>
                            <label class="form-check-label" for="flexCheckboxLg2">
                                Dakika
                            </label>
                        </div>
                    </div>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Adet</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Seçtiğiniz Hizmet Türüne Göre veri girebilirsiniz. Örn. seans seçtiğinize (10)seansı, dakika seçtiğinize (50) dk. yı temsil eder"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" class="form-control form-control-solid" placeholder="Örn. 10" name="amount" value="{{$packageSale->amount}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Toplam Tutar</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu paketi saatığınız ücret toplamı"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" class="form-control form-control-solid phone" placeholder="0.00" name="price" value="{{$packageSale->total}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Satış Tarihi</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu paketi saatığınız tarih"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid formatDateInput" placeholder="Örn. 18 Mart, 2024 12:00" name="seller_date" value="{{$packageSale->seller_date}}" />
                    <!--end::Input-->
                </div>
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->
</div>
<!--end::Aside column-->
