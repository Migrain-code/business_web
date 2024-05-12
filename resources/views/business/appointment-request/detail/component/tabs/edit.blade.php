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
                    <label class="required fs-6 fw-semibold mb-2">Adı Soyadı
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="İletişime Geçilecek Kişinin Adı ve Soyadı"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$appointmentRequest->user_name}}" />
                    <!--end::Input-->
                </div>
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Talep Durumu
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Talebinizin Durumunu Buradan Güncelleyebilirsiniz."></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-control" name="status">
                        <option value="0" @selected($appointmentRequest->status == 0)>Bekliyor</option>
                        <option value="1" @selected($appointmentRequest->status == 1)>Arandı</option>
                        <option value="2" @selected($appointmentRequest->status == 2)>Aranmadı</option>
                        <option value="3" @selected($appointmentRequest->status == 3)>Sonra Aranacak</option>
                        <option value="4" @selected($appointmentRequest->status == 4)>Sms ile Cevaplandı</option>
                    </select>
                    <!--end::Input-->
                </div>
                @if($appointmentRequest->contact_type == 2)
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">Cevabınız
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea type="text" class="form-control form-control-solid" rows="5" placeholder=""
                                  name="answer">{{$appointmentRequest->sms_content}}</textarea>
                        <!--end::Input-->
                    </div>
                @endif
                <!--begin::Input group-->
                <div class="fv-row mb-7 @if($appointmentRequest->status == 3) d-block @else d-none @endif" id="callDateInput" >
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Ne Zaman Aranacak
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi Tarih Ve saatte aranacak"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="datetime-local" class="form-control form-control-solid" placeholder="" name="call_date" value="{{$appointmentRequest->call_date}}" />
                    <!--end::Input-->
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
