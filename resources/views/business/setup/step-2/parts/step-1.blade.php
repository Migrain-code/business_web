<!--begin::Step 1-->
<div class="current" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-15">
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">İşletmenizin Detayları</h2>
            <!--end::Title-->

            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">
                Bu adımdaki işletmenizin logosunu, görsellerini ve randevu aralığını belirlemeniz önemlidir. İsteğe göre diğer bilgileri de güncelleyebilirsiniz.
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->

        <div class="fw-row mb-7 mt-3 text-center">
            <!--begin::Image input-->
            <div class="image-input image-input-empty" data-kt-image-input="true">
                <!--begin::Image preview wrapper-->
                <div class="image-input-wrapper w-125px h-125px"></div>
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
        <div class="fv-row row">
            <div class="col-6">
                <!--begin::Label-->
                <label class="form-label mb-3">İşletme Adınız
                    <span class="ms-1" data-bs-toggle="tooltip" title="İşletmenizin arama sonuçlarında görüntüleneceği adı">
	                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                </span>
                </label>
                <!--end::Label-->

                <!--begin::Input-->
                <input type="text" class="form-control form-control-lg form-control-solid" name="business_name" placeholder="" value="{{$business->name}}">
                <!--end::Input-->
            </div>
            <div class="col-6">
                <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3">Telefon Numarası
                        <span class="ms-1" data-bs-toggle="tooltip" title="İşletmenizle iletişime geçilecek telefon numarası">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                         </span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-lg form-control-solid" name="business_phone" placeholder="" value="{{$business->phone}}">
                    <!--end::Input-->
                </div>
            </div>
        </div>
        <!--begin::Input group-->
        <div class="row">
            <div class="mb-4 fv-row col-6">
                <!--begin::Label-->
                <label class="required form-label">Randevu Aralığı</label>
                <!--end::Label-->

                <!--begin::Select2-->
                <select class="form-select mb-2" name="appoinment_range" data-control="select2" data-placeholder="Randevu Aralığı Seçiniz"
                        data-allow-clear="true">
                    <option value=""></option>
                    @foreach($ranges as $range)
                        <option value="{{$range->id}}" @selected($business->appoinment_range == $range->id)>{{$range->time. ' .dk'}}</option>
                    @endforeach
                </select>
                <!--end::Select2-->

            </div>
            <!--end::Input group-->
            <div class="mb-4 fw-row col-6">
                <!--begin::Label-->
                <label class="form-label required">Kapalı Olduğu Gün
                    <span class="ms-1" data-bs-toggle="tooltip" title="İşletmeniz hangi günlerde kapalı. Seçtiğiniz günleri kapalı olarak işaretlenecektir">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Input-->
                <select name="close_day" class="form-select form-select-lg form-select-solid" data-control="select2"
                        data-placeholder="Kapalı Günü Seçiniz..." data-allow-clear="true" data-hide-search="true">
                    <option></option>
                    @foreach($dayList as $day)
                        <option value="{{$day->id}}" @selected($day->id == $business->off_day)>{{$day->name}}</option>
                    @endforeach
                </select>
                <!--end::Input-->

            </div>
        </div>


        <div class="row mb-10">
            <div class="col-6">
                <!--begin::Label-->
                <label class="form-label required">Mesai Başlangıç Saati</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="start_time" class="form-control form-control-lg form-control-solid timeSelector" value="{{old('start_time') ?? $business->start_time}}" />
                <!--end::Input-->
            </div>
            <div class="col-6">
                <!--begin::Label-->
                <label class="form-label required">Mesai Bitiş Saati</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="end_time" class="form-control form-control-lg form-control-solid timeSelector" value="{{old('end_time') ?? $business->end_time}}" />
                <!--end::Input-->
            </div>
        </div>
        <!--begin::Input group-->
        <div class="fv-row">
            <!--begin::Dropzone-->
            <div class="dropzone" id="drop_zone_area">
                <!--begin::Message-->
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                    <!--begin::Info-->
                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">İşletmeniz İçin Görsel Yükleyin.</h3>
                        <span class="fs-7 fw-semibold text-gray-500">En az 2, En fazla 5 dosya yükleyin</span>
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Dropzone-->
        </div>
        <!--end::Input group-->

    </div>
    <!--end::Wrapper-->
</div>
<!--end::Step 2-->
