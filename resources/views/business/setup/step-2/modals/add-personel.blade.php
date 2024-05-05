<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_modal_add_customer_form" data-kt-redirect="">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Personel Ekle</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_add_customer_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Ad Soyad</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{old('name')}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">E-posta</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address zorunlu"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="{{old('email')}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Telefon Numarası</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Telefon Numarası Zorunlu"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" id="validatorPhone" placeholder="" name="phone" value="{{old('phone') ?? 0}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Şifre</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Şifre Zorunlu"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="password" class="form-control form-control-solid" placeholder="" name="password" value="" />
                            <!--end::Input-->
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Onay Türü</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Randevuları Otomatik Onaylansın Mı?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="approve_type" id="approve_type" aria-label="Onay Türü Seçiniz"
                                    data-control="select2" data-placeholder="Onay Türü Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Onay Türü Seçiniz</option>
                                <option value="0" @selected(old('approve_type') == 0)>Otomatik Onay</option>
                                <option value="1" @selected(old('approve_type') == 1)>Manuel Onay</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">İzin Günleri</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel Hangi Günlerde Çalışmayacak?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="restDay[]" id="restDays" multiple aria-label="İzin Günleri Seçiniz"
                                    data-control="select2" data-placeholder="İzin Günleri Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">İzin Günleri Seçiniz</option>
                                @foreach($dayList as $day)
                                    <option value="{{$day->id}}" @selected(old('restDay') != null ? in_array($day->id, old('restDay')) : "")>{{$day->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmet Sunulan Cinsiyet</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hizmet Sunulan Cinsiyet Seçiniz"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="gender_type" id="gender_type" aria-label="Hizmet Sunulan Cinsiyet Seçiniz"
                                    data-control="select2" data-placeholder="Hizmet Sunulan Cinsiyet Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Hizmet Sunulan Cinsiyet Seçiniz</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}" @selected(old('gender_type') == $type->id)>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Kasa Yetkisi</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel Kasa Yetkilerine Erişebilsin mi?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="is_case" id="is_case" aria-label="Kasa Yetkisi Seçiniz"
                                    data-control="select2" data-placeholder="Kasa Yetkisi Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Kasa Yetkisi Seçiniz</option>
                                <option value="0">Yetki Verme</option>
                                <option value="1">Yetki Ver</option>
                            </select>
                        </div>
                        <!--end::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Randevu Aralığı</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel Kaç DK ara ile randevu kabul edecek?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="range" id="range" aria-label="Randevu Aralığı Seçiniz"
                                    data-control="select2" data-placeholder="Randevu Aralığı Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Randevu Aralığı Seçiniz</option>
                                @foreach($ranges as $range)
                                    <option value="{{$range->id}}" @selected(old('range') == $range->id)>{{$range->time. ' .dk'}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmet Payı</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel verdiği hizmetlerde yüzde kaç pay alacak?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="rate" id="rate" aria-label="Hizmet Payı Seçiniz"
                                    data-control="select2" data-placeholder="Hizmet Payı Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Hizmet Payı Seçiniz</option>
                                @for($i=0; $i <= 100; $i++)
                                    <option value="{{$i}}" @selected(old('rate') == $i)>{{$i.'%'}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Satış Payı</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel yaptığı satışlardan yüzde kaç pay alacak?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="product_rate" id="product_rate" aria-label="Satış Payı Seçiniz"
                                    data-control="select2" data-placeholder="Satış Payı Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Satış Payı Seçiniz</option>
                                @for($i=0; $i <= 100; $i++)
                                    <option value="{{$i}}" @selected(old('rate') == $i)>{{$i.'%'}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="required">Hizmetler</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel işletmenizde hangi hizmetleri verecek?"></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="services[]" multiple  id="serviceSelectInput" aria-label="Hizmet Seçiniz"
                                    data-control="select2" data-placeholder="Hizmet Seçiniz..."
                                    data-dropdown-parent="#kt_modal_add_customer" class="form-select form-select-solid fw-bold">
                                <option value="">Hizmet Seçiniz</option>
                                @for($i=0; $i <= 100; $i++)
                                    <option value="{{$i}}" @selected(old('rate') == $i)>{{$i.'%'}}</option>
                                @endfor
                            </select>
                        </div>
                        <!--begin::Billing toggle-->
                        <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse" href="#kt_modal_add_customer_billing_info" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">
                            Çalışma Saatleri
                            <span class="ms-2 rotate-180">
																<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                        <!--end::Billing toggle-->
                        <!--begin::Billing form-->
                        <div id="kt_modal_add_customer_billing_info" class="collapse show">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Mesai Başlangıç Saati</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel Kaçta İşe Başlayacak"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="time" class="form-control form-control-solid" placeholder="" name="start_time"  value="{{old('start_time') ?? authUser()->business->start_time}}" />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Mesai Bitiş Saati</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel İşi Kaçta Bırakacak"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="time" class="form-control form-control-solid" placeholder="" name="end_time"  value="{{old('end_time') ?? authUser()->business->end_time}}" />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Yemek Başlangıç Saati</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel Yemek Molasına Başlayacak"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="time" class="form-control form-control-solid" placeholder="" name="food_start_time"  value="" />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="required">Yemek Bitiş Saati</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Personel Yemek Molası Kaçta Bitirecek"></i>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="time" class="form-control form-control-solid" placeholder="" name="food_end_time"  value="" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Billing form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3">İptal Et</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="kt_modal_add_customer_submit" class="btn btn-primary">
                        <span class="indicator-label">Kaydet</span>
                        <span class="indicator-progress">Lütfen Bekleyin...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->
