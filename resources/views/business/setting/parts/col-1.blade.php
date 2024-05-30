<div class="d-flex flex-column gap-7 gap-lg-10 w-100 mb-7 me-lg-10">
    <!--begin::Thumbnail settings-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Görsel</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Personel Avatar Card-->
        <div class="card-body text-center pt-0">
            <!--begin::Image input-->
            <!--begin::Image input placeholder-->
            <style>
                .image-input-placeholder {
                    background-image: url('{{image($business->logo)}}');
                }

                [data-bs-theme="dark"] .image-input-placeholder {
                    background-image: url('{{image($business->logo)}}');
                }
            </style>
            <!--end::Image input placeholder-->

            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                 data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-150px h-150px" style="background-image: url('{{image($business->logo)}}')"></div>
                <!--end::Preview existing avatar-->

                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                       data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Değiştir">
                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span
                            class="path2"></span></i>
                    <!--begin::Inputs-->
                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                    <input type="hidden" name="avatar_remove">
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->

                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="İptal Et">
                <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>            </span>
                <!--end::Cancel-->

                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                      data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Sil">
                <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>            </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->

            <!--begin::Description-->
            <div class="text-muted fs-7">
                İşletme Logosunu ayarlayın. Yalnızca *.png,
                *.jpg ve *.jpeg resim dosyaları kabul edilir
            </div>
            <!--end::Description-->
        </div>
        <!--end::Personel Avatar Card-->
    </div>
    <!--end::Thumbnail settings-->
    <!--begin::Status-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Onay Türü</h2>
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <div class="rounded-circle bg-success w-15px h-15px"
                     id="kt_ecommerce_add_product_status"></div>
            </div>
            <!--begin::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Select2-->
            <select class="form-select mb-2" name="approve_type" data-control="select2" data-hide-search="true"
                    data-placeholder="Onay Türü Seçiniz" id="kt_ecommerce_add_product_status_select">
                <option></option>
                <option value="0" @selected($business->approve_type == 0)>Otomatik Onay</option>
                <option value="1" @selected($business->approve_type == 1)>Manuel Onay</option>
            </select>
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7">Randevularınız otomatik onaylansın mı?</div>
            <!--end::Description-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Status-->
    <!--begin::Status-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Stok Alarmı</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Select2-->
            <input type="number" value="{{$business->stock_count}}" name="stock_count" class="form-control form-control-solid">
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7">Stok sayınız belirlenen seviyenin altına düştüğünde uyarı alacaksınız.</div>
            <!--end::Description-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Status-->
    <!--begin::Category & tags-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Çalışma Saatleri</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->
            <!--begin::Label-->
            <label class="form-label">Kapalı Gün</label>

            <!--begin::Select2-->
            <select class="form-select mb-2" name="off_day" data-control="select2" data-placeholder="İzin Günü Seçiniz" data-allow-clear="true">
                <option></option>
                @foreach($dayList as $day)
                    <option value="{{$day->id}}" @selected(isset($business->off_day) ? $day->id == $business->off_day : false)>{{$day->name}}</option>
                @endforeach
            </select>
            <!--end::Select2-->

            <div class="col-12">
                <!--begin::Label-->
                <label class="form-label required">Mesai Başlangıç Saati</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="start_time" class="form-control form-control-lg form-control-solid timeSelector" value="{{$business->start_time}}" />
                <!--end::Input-->
            </div>
            <div class="col-12">
                <!--begin::Label-->
                <label class="form-label required">Mesai Bitiş Saati</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="end_time" class="form-control form-control-lg form-control-solid timeSelector" value="{{$business->end_time}}" />
                <!--end::Input-->
            </div>


        </div>
        <!--end::Card body-->
    </div>
    <!--end::Category & tags-->

</div>
