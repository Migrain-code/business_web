<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10 me-lg-10 mb-7">
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
                    <label class="required form-label">Adı Soyadı</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input type="text" name="name" class="form-control mb-2"
                           placeholder="Personel Adı" value="{{$personel->name}}">
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
                           placeholder="E-posta" value="{{$personel->email}}">
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
                           placeholder="Telefon Numarası" value="{{$personel->phone}}">
                    <!--end::Input-->

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-4 fv-row">
                    <!--begin::Label-->
                    <label class="required form-label" data-bs-toggle="tooltip" title="Şifreyi Değiştrmek istiyorsanız doldurun">Şifre</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <input type="password" name="password" class="form-control mb-2"
                           placeholder="Şifre" value="">
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
                        <option value="0" @selected($personel->accepted_type == 0)>Otomatik Onay</option>
                        <option value="1" @selected($personel->accepted_type == 1)>Manuel Onay</option>
                    </select>
                    <!--end::Select2-->

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-4 fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Hizmet Sunulan Cinsiyet</label>
                    <!--end::Label-->

                    <!--begin::Select2-->
                    <select class="form-select mb-2" name="gender_type" data-control="select2" data-placeholder="Hizmet Sunulan Cinsiyet Seçiniz"
                            data-allow-clear="true">
                        <option value=""></option>
                        @foreach($types as $type)
                            <option value="{{$type->id}}" @selected($personel->gender == $type->id)>{{$type->name}}</option>
                        @endforeach
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
                            <option value="{{$range->id}}" @selected($personel->range == $range->id)>{{$range->time. ' .dk'}}</option>
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
                            <option value="{{$i}}" @selected($personel->rate == $i)>{{$i.'%'}}</option>
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
                            <option value="{{$i}}" @selected($personel->product_rate == $i)>{{$i.'%'}}</option>
                        @endfor
                    </select>
                    <!--end::Select2-->
                </div>

                <!--end::Input group-->

                @if($personel->business->rooms->where('status', 1)->count() > 0)
                    <div class="mb-4 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Salon</label>
                        <!--end::Label-->

                        <!--begin::Select2-->
                        <select class="form-select mb-2" name="salons[]" multiple data-control="select2" data-placeholder="Salon Seçiniz"
                                data-allow-clear="true">
                            <option value=""></option>
                            <option value="0" @selected(in_array(0, $roomIds))>Salon</option>
                            @foreach($personel->business->rooms as $room)
                                <option value="{{$room->id}}" @selected(in_array($room->id, $roomIds))>{{$room->name}}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>
                @endif

                <!--begin::Input group-->
                <div class="mb-4 fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Açıklama</label>
                    <!--end::Label-->

                    <textarea class="form-control" name="description" rows="7">{{$personel->description}}</textarea>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::General options-->
    </div>

</div>
