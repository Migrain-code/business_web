<!--begin:::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_customer_general" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Yetkili Bilgileri</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                <div class="fw-row mb-7 mt-3 text-center">
                    <!--begin::Image input-->
                    <div class="image-input image-input-empty" data-kt-image-input="true">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{image($official->image)}}')"></div>
                        <!--end::Image preview wrapper-->

                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                               data-kt-image-input-action="change"
                               data-bs-dismiss="click"
                        >
                            <i class="fa fa-edit fs-6"><span class="path1"></span><span class="path2"></span></i>

                            <!--begin::Inputs-->
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->

                        <!--begin::Cancel button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="cancel"
                              data-bs-toggle="tooltip"
                              data-bs-dismiss="click"
                              title="Fotoğrafı Kaldır">
                                    <i class="fa fa-xmark fs-3"></i>
                                </span>
                        <!--end::Cancel button-->

                        <!--begin::Remove button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                              data-kt-image-input-action="remove"
                              data-bs-toggle="tooltip"
                              data-bs-dismiss="click"
                              title="Fotoğrafı Kaldır">
                                    <i class="fa fa-xmark fs-3"></i>
                                </span>
                        <!--end::Remove button-->
                    </div>
                    <!--end::Image input-->
                </div>
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Adı Soyadı</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yetkilinin Adı Soyadı."></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$official->name}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Telefon
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yetkilinin telefonu girişte kullanılacak"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" id="phone" class="form-control form-control-solid" placeholder="" name="phone" value="{{formatPhone($official->phone)}}" />
                    <!--end::Input-->
                </div>

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">E-Posta
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yetkilinin e-posta adresi"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="{{$official->email}}" />
                    <!--end::Input-->
                </div>

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Şifre
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yetkilinin girişte kullanacağı şifresi"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password" class="form-control form-control-solid" placeholder="" name="password" value="" />
                    <!--end::Input-->
                </div>

                <!--begin::Input group-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Şube</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yetkiliye Atanacak Şubeyi Seçiniz"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="branch_id" id="city_select" aria-label="Şube Seçiniz" data-control="select2" data-placeholder="Şube Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_profile" class="form-select form-select-solid fw-bold">
                        <option value="">Şube Seçiniz</option>
                        @foreach($branches as $branche)
                            <option value="{{$branche->id}}" @selected($branche->id == $official->business_id)>{{$branche->branch_name ?? $branche->name}}</option>
                        @endforeach
                    </select>
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
