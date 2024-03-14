<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_general" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Profile</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                <!--begin::Input group-->
                <div class="mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span>Profili Güncelle</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg."></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Image input wrapper-->
                    <div class="mt-1">
                        <!--begin::Image input placeholder-->
                        <style>.image-input-placeholder { background-image: url('/assets/media/svg/files/blank-image.svg'); } [data-theme="dark"] .image-input-placeholder { background-image: url('/assets/media/svg/files/blank-image-dark.svg'); }</style>
                        <!--end::Image input placeholder-->
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{image($customer->image)}})"></div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Edit-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																				<i class="bi bi-x fs-2"></i>
																			</span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																				<i class="bi bi-x fs-2"></i>
																			</span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->
                    </div>
                    <!--end::Image input wrapper-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2 required">Ad Soyad</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$customer->name}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Row-->
                <div class="row row-cols-1 row-cols-md-2">
                    <!--begin::Col-->
                    <div class="col">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Email</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="{{$customer->email}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Randevu Telefonu</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" data-inputmask="'mask': '(999) 999-9999'" placeholder="Randevu telefonu" name="app_phone" value="{{$customer->app_phone}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row row-cols-1 row-cols-md-2">
                    <!--begin::Col-->
                    <div class="col">
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Şehir</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Country of origination"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="city_id" id="city_select" aria-label="Şehir Seçiniz" class="form-select form-select-solid fw-bold">
                                <option value="">Şehir Seçiniz</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @selected($city->id == $customer->city_id)>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">İlçe</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Eğer Bu Liste Boş ise şehir seçmeniz gerekmektedir"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="district_id" id="district_select" class="form-select form-select-solid fw-bold">
                                <option value="">İlçe Seçiniz</option>

                            </select>
                        </div>
                        <!--end::Input group-->
                    </div>

                </div>

                <div class="row row-cols-1 row-cols-md-2">
                    <!--begin::Col-->
                    <div class="col">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Doğum Tarihi</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" class="form-control form-control-solid" placeholder="" name="birthday" value="{{$customer->birthday}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Cinsiyet</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="d-flex">
                                <div class="form-check form-check-custom form-check-solid form-check-lg me-2">
                                    <input class="form-check-input" name="gender"  @checked($customer->gender == "1") type="radio" value="1" id="flexCheckboxLg1"/>
                                    <label class="form-check-label" for="flexCheckboxLg1">
                                        Kadın
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid form-check-lg">
                                    <input class="form-check-input" name="gender" @checked($customer->gender == "2") type="radio" value="2" id="flexCheckboxLg2"/>
                                    <label class="form-check-label" for="flexCheckboxLg2">
                                        Erkek
                                    </label>
                                </div>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>

                    <!--end::Col-->
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
