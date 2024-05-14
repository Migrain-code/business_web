<!--begin::Aside column-->
<div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">

    <!--begin::Order details-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Hizmeti Güncelle</h2>
            </div>

        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="d-flex flex-column gap-3" id="kt_modal_add_customer" data-kt-redirect="{{route('business.service.index')}}">
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
                            <option value="{{$serviceCategorie->id}}" @selected($serviceCategorie->id == $service->category)>{{$serviceCategorie->name}}</option>
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
                        @foreach($service->categorys->subCategories as $serviceSubCategorie)
                            <option value="{{$serviceSubCategorie->id}}" @selected($serviceSubCategorie->id == $service->sub_category)>{{$serviceSubCategorie->name}}</option>
                        @endforeach
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
                                <input class="form-check-input" name="type_id" type="radio" value="{{$type->id}}" @checked($service->type == $type->id) id="flexCheckboxLg1"/>
                                <label class="form-check-label" for="flexCheckboxLg1">
                                    {{$type->name}}
                                </label>
                            </div>

                        @endforeach

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
                    <input type="number" class="form-control form-control-solid" placeholder="Örn. 10" name="time" value="{{$service->time}}" />
                    <!--end::Input-->
                </div>

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
                            <input class="form-check-input" @checked($service->price_type_id == 0) name="price_type_id" type="radio" value="0" id="flexCheckboxLgType1"/>
                            <label class="form-check-label" for="flexCheckboxLgType1">
                                Tek Fiyat
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid form-check-lg me-2" >
                            <input class="form-check-input" @checked($service->price_type_id == 1) name="price_type_id" type="radio" value="1" id="flexCheckboxLgType2"/>
                            <label class="form-check-label" for="flexCheckboxLgType2">
                                Aralıklı Fiyat
                            </label>
                        </div>
                    </div>
                    <!--end::Input-->
                </div>

                <div class="fv-row mb-7" id="singlePrice">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Hizmet Fiyatı</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu hizmetin ücreti"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" class="form-control form-control-solid phone" placeholder="0.00" name="price" value="{{$service->price}}" />
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
                        <input type="number" class="form-control form-control-solid me-2" placeholder="En Düşük Fiyat" name="min_price" value="{{$service->price}}" />
                        <!--end::Input-->
                        <!--begin::Input-->
                        <input type="number" class="form-control form-control-solid phone" placeholder="En Yüksek Fiyat" name="max_price" value="{{$service->max_price}}" />
                        <!--end::Input-->
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center gap-3">
                    <a href="{{url()->previous()}}" class="btn btn-danger">
                        İptal Et
                    </a>
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Güncelle
                        </span>
                        <span class="indicator-progress">
                    Hizmet Güncelleniyor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->
</div>
<!--end::Aside column-->
