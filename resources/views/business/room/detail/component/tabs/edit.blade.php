<!--begin:::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_customer_general" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Oda Bilgileri</h2>
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
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Oda Adı</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Odanın Adı."></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$room->name}}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Renk Kodu
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Oda Başlığı Listede Hangi Renkte Gösterilsin"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="color" class="form-control form-control-solid" placeholder="" name="color_code" style="height: 40px;" value="{{$room->color}}" />
                    <!--end::Input-->
                </div>

                <!--begin::Input group-->
                <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">
                        <span class="required">Fiyat Türü</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu odada fiyatlar hangi tipte arttırılacak"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="increase_type" id="increaseTypeSelect" aria-label="Fiyat Türü Seçiniz" data-control="select2" data-placeholder="Fiyat Türü Seçiniz..." data-dropdown-parent="#kt_ecommerce_customer_general" class="form-select form-select-solid fw-bold">
                        <option value="">Fiyat Türü Seçiniz</option>
                        {{--
                            <option value="0" @selected($room->increase_type == 0)>TL Fiyat Arttırma</option>
                        --}}
                        <option value="1" @selected($room->increase_type == 1)>Yüzdelik Fiyat Arttırma</option>
                    </select>
                </div>
                <!--end::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2"><b id="increaseTypeText">Fiyat</b>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Bu odada fiyatlar kaç arttırılacak"></i>
                    </label> <br>
                    <label class="text-danger my-1" id="increaseTypeNote">Hizmet Bedelinin üzerine eklenecek tutarı giriniz</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" class="form-control form-control-solid" id="increaseTypeInput" name="price" value="{{$room->price}}" />
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
