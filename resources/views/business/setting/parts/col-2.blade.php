<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 me-lg-10">
    <div class="">

        <!--begin::General options-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Genel Bilgiler</h2>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <div class="mb-4 fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">İşletme Adı</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input type="text" name="name" class="form-control mb-2"
                           placeholder="Personel Adı" value="{{$business->name}}">
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
                           placeholder="E-posta" value="{{$business->business_email}}">
                    <!--end::Input-->

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-4 fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Telefon Numarası</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input type="text" name="phone" class="form-control mb-2"
                           placeholder="Telefon Numarası" value="{{$business->phone}}">
                    <!--end::Input-->

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
                            <option value="{{$range->id}}" @selected($business->appoinment_range == $range->id)>{{$range->time. ' .dk'}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->

                </div>
                <!--end::Input group-->
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
                <div class="row mb-10">
                    <div class="fv-row col-6">
                        <!--begin::Label-->
                        <label class="required form-label">İşletme Kategoriniz</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select name="category_id" id="category_select" aria-label="İşletme Kategorisi Seçiniz" data-control="select2" data-placeholder="İşletme Kategorisi Seçiniz..."  class="form-select form-select-solid fw-bold">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" @selected($category->id == $business->category_id)>{{$category->getName()}}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>
                    <div class="mb-4 fv-row col-6">
                        <!--begin::Label-->
                        <label class="required form-label">Hizmet Sunulan Cinsiyet</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select form-select-solid fw-bold" id="type_id" name="type_id" data-control="select2" data-placeholder="Hizmet Sunulan Cinsiyet Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}" @selected($business->type_id == $type->id)>{{$type->name}}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->

                    </div>
                </div>
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

                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Option-->
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4">
                                <input type="radio" class="btn-check" name="team_size" @checked($business->personal_count == "50+") value="50+">
                                <span class="fw-bold fs-3">50+</span>
                            </label>
                            <!--end::Option-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-4 fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">İşletme Hakkında Metni</label>
                    <!--end::Label-->
                    <div id="kt_forms_widget_1_editor">{!! $business->about !!}</div>
                    <input type="hidden" id="about" name="about_content" value="{!! $business->about !!}">
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::General options-->
    </div>

</div>
