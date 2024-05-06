<div class="scroll-x mb-5">
    <div class="row" style="width: 2000px;">
        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100 me-3" style="max-width: 300px; background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->total}}₺</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Paketin Toplam</span>
                        <span class="">Tutarı</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>

        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100 me-3" style="max-width: 300px; background-color: #484286;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->payeds->sum('price')}}₺</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Paketin Ödenen</span>
                        <span class="">Tutarı</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>

        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100 me-3" style="max-width: 300px; background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->total - $packageSale->payeds->sum('price')}}₺</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Paketin Kalan</span>
                        <span class="">Ödemesi</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>

        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100 me-3" style="max-width: 300px; background-color: #484286;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                            <span class="fs-3hx text-white fw-bold me-6">
                                {{$packageSale->amount}}
                            </span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Paketin Toplam</span>
                        <span class="">{{$packageSale->packageType("name")}} Limiti</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>

        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100 me-3" style="max-width: 300px; background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->usages->sum('amount')}}</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Paketin Kullanılan</span>
                        <span class="">{{$packageSale->packageType('name')}}</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>

        <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100 me-3" style="max-width: 300px; background-color: #484286;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">

            <!--begin::Card body-->
            <div class="card-body d-flex align-items-end mb-3">
                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <span class="fs-3hx text-white fw-bold me-6">{{$packageSale->amount - $packageSale->usages->sum('amount')}}</span>

                    <div class="fw-bold fs-4 text-white">
                        <span class="d-block">Paketin Kalan</span>
                        <span class="">{{$packageSale->packageType('name')}}</span>
                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Card body-->

        </div>

    </div>

</div>
