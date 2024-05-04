<!--begin::Modal - Customers - Add-->
<div class="modal fade" id="kt_modal_add_personel" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Personel Ekle</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close" data-bs-dismiss="modal" class="btn btn-icon btn-sm btn-active-icon-primary">
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
                <form class="modal-body py-10 px-lg-17" id="personelAddForm">
                    <!--begin::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Adı Soyadı</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" name="name" class="form-control mb-2"
                               placeholder="Personel Adı" value="{{old('name')}}">
                        <!--end::Input-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">E-posta</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" name="email" class="form-control mb-2"
                               placeholder="E-posta" value="{{old('email')}}">
                        <!--end::Input-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Telefon Numarası</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" name="phone" id="validatorPhone" class="form-control mb-2"
                               placeholder="Telefon Numarası" value="{{old('phone') ?? 0}}">
                        <!--end::Input-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Şifre</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="password" name="password" class="form-control mb-2"
                               placeholder="Şifre" value="{{old('password')}}">
                        <!--end::Input-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Onay Türü</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="approve_type" data-control="select2" data-placeholder="Onay Türünü Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>
                            <option value="0" @selected(old('approve_type') == 0)>Otomatik Onay</option>
                            <option value="1" @selected(old('approve_type') == 1)>Manuel Onay</option>
                        </select>
                        <!--end::Select2-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Label-->
                    <div class="fw-row">
                        <label class="form-label">İzin Günleri</label>

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="restDay[]" data-control="select2" data-placeholder="İzin Günü Seçiniz"
                                multiple="multiple">
                            <option></option>
                            @foreach($dayList as $day)
                                <option value="{{$day->id}}" @selected(old('restDay') != null ? in_array($day->id, old('restDay')) : "")>{{$day->name}}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>

                    <div class="col-12">
                        <!--begin::Label-->
                        <label class="form-label required">Mesai Başlangıç Saati</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input name="start_time" class="form-control form-control-lg form-control-solid timeSelector" value="{{old('start_time') ?? authUser()->business->start_time}}" />
                        <!--end::Input-->
                    </div>
                    <div class="col-12">
                        <!--begin::Label-->
                        <label class="form-label required">Mesai Bitiş Saati</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input name="end_time" class="form-control form-control-lg form-control-solid timeSelector" value="{{old('end_time') ?? authUser()->business->end_time}}" />
                        <!--end::Input-->
                    </div>

                    <div class="col-12">
                        <!--begin::Label-->
                        <label class="form-label required">Yemek Başlangıç Saati</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input name="food_start_time" class="form-control form-control-lg form-control-solid timeSelector" minlength="{{authUser()->business->food_start_time}}" placeholder="Seçiniz" value="{{old('food_start_time') ?? authUser()->business->food_start_time}}" />
                        <!--end::Input-->
                    </div>
                    <div class="col-12">
                        <!--begin::Label-->
                        <label class="form-label required">Yemek Bitiş Saati</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input name="food_end_time" class="form-control form-control-lg form-control-solid timeSelector" placeholder="Seçiniz" value="{{old('food_end_time') ?? authUser()->business->food_end_time}}" />
                        <!--end::Input-->
                    </div>
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Hizmet Sunulan Cinsiyet</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="gender_type" data-control="select2" data-placeholder="Hizmet Sunulan Cinsiyet Seçiniz" data-allow-clear="true">
                            <option value=""></option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}" @selected(old('gender_type') == $type->id)>{{$type->name}}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->

                    </div>
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Kasa Yetkisi</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="is_case" data-control="select2" data-placeholder="Kasa Yetki Durumu Seçiniz" data-allow-clear="true">
                            <option value=""></option>
                            <option value="0">Yetki Verme</option>
                            <option value="1">Yetki Ver</option>
                        </select>
                        <!--end::Select2-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Randevu Aralığı</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="range" data-control="select2" data-placeholder="Randevu Aralığı Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>
                            @foreach($ranges as $range)
                                <option value="{{$range->id}}" @selected(old('range') == $range->id)>{{$range->time. ' .dk'}}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Hizmet Payı</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="rate" data-control="select2" data-placeholder="Hizmet Payı Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>
                            @for($i=0; $i <= 100; $i++)
                                <option value="{{$i}}" @selected(old('rate') == $i)>{{$i.'%'}}</option>
                            @endfor
                        </select>
                        <!--end::Select2-->

                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Satış Payı</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="product_rate" data-control="select2" data-placeholder="Satış Payı Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>
                            @for($i=0; $i <= 100; $i++)
                                <option value="{{$i}}" @selected(old('product_rate') == $i)>{{$i.'%'}}</option>
                            @endfor
                        </select>
                        <!--end::Select2-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Hizmetler</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" multiple id="serviceSelectInput" name="services[]" data-control="select2" data-placeholder="Personelin Vereceği Hizmetleri Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>

                        </select>
                        <!--end::Select2-->
                    </div>
                    <!--end::Input group-->
                </form>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" data-bs-dismiss="modal" class="btn btn-light me-3">İptal Et</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="kt_modal_add_personel_submit" class="btn btn-primary">
                        <span class="indicator-label">Kaydet</span>
                        <span class="indicator-progress">Lütfen Bekleyin...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - Customers - Add-->
