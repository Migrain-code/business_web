<!--begin::Step 2-->
<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-15">
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">İşletmenizin Detayları</h2>
            <!--end::Title-->

            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">
               Bu adımdaki bilgiler işletmenizin işlevsellik kazanması için gerekli bilgilerini içerecektir.
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="mb-10 fv-row">
            <!--begin::Label-->
            <label class="d-flex align-items-center form-label mb-3">
               Personel Sayınız

                <span class="ms-1" data-bs-toggle="tooltip" title="Seçtiğiniz personel saysına göre size paket önerisinde bulunabiliriz">
	                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                </span>
            </label>
            <!--end::Label-->

            <!--begin::Row-->
            <div class="row mb-2" data-kt-buttons="true">
                <!--begin::Col-->
                <div class="col">
                    <!--begin::Option-->
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4">
                        <input type="radio" class="btn-check" name="team_size" @checked($business->personal_count == "1-1") value="1-1">
                        <span class="fw-bold fs-3">1-1</span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col">
                    <!--begin::Option-->
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4 active">
                        <input type="radio" class="btn-check" name="team_size" @checked($business->personal_count == "2-10") value="2-10">
                        <span class="fw-bold fs-3">2-10</span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col">
                    <!--begin::Option-->
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4">
                        <input type="radio" class="btn-check" name="team_size" @checked($business->personal_count == "10-50") value="10-50">
                        <span class="fw-bold fs-3">10-50</span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->

        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row row">
            <div class="col-12 col-lg-6 mb-10">
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
            <div class="col-12 col-lg-6">
                <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3">İşletme Telefon Numarası
                        <span class="ms-1" data-bs-toggle="tooltip" title="İşletme Telefon Numarası">
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
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="form-label required">Salon Türü
                    <span class="ms-1" data-bs-toggle="tooltip" title="İşletmeniz hangi cinsiyete hizmet veriyor. Eğer her ikisine de hizmet veriyorsanız unisex seçeneğini seçiniz">
                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                    </span>
                </label>
                <!--end::Label-->

                <!--begin::Input-->
                <select name="business_type" class="form-select form-select-lg form-select-solid" data-control="select2" data-placeholder="Salon Türü Seçinizi..." data-allow-clear="true" data-hide-search="true">
                    <option></option>
                    <option value="1" @selected($business->type_id == "1")>Kadın</option>
                    <option value="2" @selected($business->type_id == "2")>Erkek</option>
                    <option value="3" @selected($business->type_id == "3")>Unisex</option>
                </select>
                <!--end::Input-->
        </div>
        <div class="row mb-10">
            <div class="fv-row col-6">
                <!--begin::Label-->
                <label class="required form-label">Şehir Seçiniz</label>
                <!--end::Label-->

                <!--begin::Select2-->
                <select name="city_id" id="city_select" aria-label="Şehir Seçiniz" data-control="select2" data-placeholder="Şehir Seçiniz..."  class="form-select form-select-solid fw-bold">
                    <option></option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}" @selected($business->city == $city->id)>{{$city->name}}</option>
                    @endforeach
                </select>
                <!--end::Select2-->
            </div>
            <div class="fv-row col-6">
                <!--begin::Label-->
                <label class="required form-label">İlçe Seçiniz</label>
                <!--end::Label-->

                <!--begin::Select2-->
                <select name="district_id" id="district_select" aria-label="İlçe Seçiniz" data-control="select2" data-placeholder="İlçe Seçiniz..."  class="form-select form-select-solid fw-bold">
                    <option></option>
                    @if(isset($business->city))
                        @foreach($business->cities->district as $district)
                            <option value="{{$district->id}}" @selected($district->id == $business->district)>{{$district->name}}</option>
                        @endforeach
                    @endif
                </select>
                <!--end::Select2-->
            </div>
        </div>
        <!--end::Input group-->
        <div class="fw-row mb-10">
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
                        data-placeholder="Kapalı Güni Seçiniz..." data-allow-clear="true" data-hide-search="true">
                    <option></option>
                    @foreach($dayList as $day)
                        <option value="{{$day->id}}" @selected($day->id == $business->off_day)>{{$day->name}}</option>
                    @endforeach
                </select>
                <!--end::Input-->

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

        <div class="row">
            <!--begin::Label-->
            <label class="form-label required">İşletme Hakkında</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div id="kt_forms_widget_1_editor">{!! $business->about !!}</div>
            <!--end::Input-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Step 2-->
