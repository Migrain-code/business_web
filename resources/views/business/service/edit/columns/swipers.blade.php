<div class="swiper-slide">
    <!--begin::Col-->
    <div class="col-12">
        <!--begin::Card widget 3-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$appointmentCount}}</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Hizmetten Kaç adet</span>
                        <span class="">randevu alındı</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>
        <!--end::Card widget 3-->
    </div>
    <!--end::Col-->
</div>
<div class="swiper-slide">
    <!--begin::Col-->
    <div class="col-12">
        <!--begin::Card widget 3-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #0da141;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$personelCount}}</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Kaç Personel Bu</span>
                        <span class="">Hizmeti Veriyor</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>
        <!--end::Card widget 3-->
    </div>
    <!--end::Col-->
</div>
<div class="swiper-slide">
    <!--begin::Col-->
    <div class="col-12">
        <!--begin::Card widget 3-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #9b0b62;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{formatPrice($packageCount)}}</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Hizmetin Satışılardan</span>
                        <span class="">Getirisi</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>
        <!--end::Card widget 3-->
    </div>
    <!--end::Col-->
</div>
<div class="swiper-slide">
    <div class="col-12">
        <!--begin::Card widget 3-->
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: rgba(255,255,255,0.38);background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                                <span class="fs-3hx text-white fw-bold me-6">
                                    {{formatPrice($appointmentCount * $service->price)}}
                                </span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Hizmetin Randevulardan</span>
                        <span class="">Getirisi</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>
        <!--end::Card widget 3-->
    </div>
</div>
