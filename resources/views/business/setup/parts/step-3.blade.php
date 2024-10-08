<!--begin::Step 3-->

<div data-kt-stepper-element="content">
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

        <div class="row mb-10 fv-row">
            <label class="d-flex align-items-center form-label mb-3">
                İşletmenizin Konumu

                <span class="ms-1" data-bs-toggle="tooltip" title="Seçtiğiniz konuma göre adresiniz otomatik alınacaktır ve yol tarifi eklenecektir">
	                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                </span>
                <input type="search" name="searchInput" class="form-control" id="searchInput" placeholder="Adresinizi yazarak arayabilirsiniz">

            </label>
            <!--end::Label-->
            <input type="hidden" name="latitude" id="latitude" value="{{$business->lat}}">
            <input type="hidden" name="longitude" id="longitude" value="{{$business->longitude}}">

            <!-- Harita Seçimi Alanı -->
            <div id="map-container" style="position: relative;">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
        <div class="row mb-10 fv-row">
            <label class="d-flex align-items-center form-label mb-3">
                İşletmenizin Açık Adresi

                <span class="ms-1" data-bs-toggle="tooltip" title="İşletmenizin açık adresi bu alana seçtiğinizde otomatik gelir gelmez ise el ile girmeniz gerekmektedir">
	                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                </span>
            </label>

            <textarea class="form-control" name="address" id="address" rows="6">{{$business->address}}</textarea>
            <input type="hidden" id="embed" name="embed" value="{{$business->embed}}">
        </div>
    </div>

</div>
<!--end::Step 3-->
