<div data-kt-stepper-element="content">
    <!--begin::Plans-->
    <div class="d-flex flex-column">
        <!--begin::Heading-->
        <div class="mb-13 text-center">
            <h1 class="fs-2hx fw-bold mb-5">Planınızı Seçin</h1>

            <div class="text-gray-600 fw-semibold fs-5">
               Planınızı seçtikten sonra ödeme adımına geçeceksiniz. Ödeme adımında seçtiğiniz paketin tutarında ödeme yapacaksınız.
            </div>
        </div>
        <!--end::Heading-->
        <style>
            .nav-line-tabs .nav-item .nav-link {
                color: var(--bs-gray-500);
                border: 0;
                border-bottom: 1px solid transparent;
                transition: color .2s ease;
                padding: 1rem;
                margin: 0 0.4rem;
                border-top-left-radius: 0px;
                border-top-right-radius: 0px;
                border-radius: 1.5rem;
                width: 100px;
                text-align: center;
            }
        </style>
        <!--begin::Nav group-->
        <div class="nav-group nav-group-outline mx-auto mb-15">
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold m-2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-white bg-active-primary pb-4 active" data-bs-toggle="tab"
                       href="#monthly_package_tab">Aylık</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-white bg-active-primary pb-4" data-bs-toggle="tab"
                       href="#yearly_package_tab">Yıllık</a>
                </li>
            </ul>
        </div>
        <!--end::Nav group-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="monthly_package_tab" role="tabpanel">
                <!--begin::Row-->
                <div class="row g-10">
                    @foreach($monthlyPackages as $package)
                        <!--begin::Col-->
                        <div class="col-xl-4">
                            <div class="d-flex h-100 align-items-center">
                                <!--begin::Option-->
                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-bolder">{{$package->name}}</h1>
                                        <!--end::Title-->

                                        <!--begin::Price-->
                                        <div class="text-center">
                                            <span class="mb-2 text-primary"></span>

                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
                                        {{$package->price ==  0 ? "Ücretsiz" : formatPrice($package->price)}}
                                    </span>
                                        </div>
                                        <!--end::Price-->
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Features-->
                                    <div class="w-100 mb-10">
                                        @php
                                            $propartieArray = $package->proparties->pluck('propartie_id')->toArray();
                                            $disabledProparies = $package->disabledProparties->pluck('propartie_id')->toArray();
                                        @endphp
                                        @foreach($proparties as $propartie)
                                            @if(!in_array($propartie->id, $disabledProparies))
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-5">
                                              <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                  {{$propartie->name}}
                                              </span>
                                                    @if(in_array($propartie->id, $propartieArray))
                                                        <i class="ki-duotone ki-check-circle fs-1 text-success">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    @else
                                                        <i class="ki-duotone ki-cross-circle fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    @endif

                                                </div>
                                                <!--end::Item-->
                                            @endif
                                        @endforeach


                                    </div>
                                    <!--end::Features-->

                                    <!--begin::Option-->
                                    <input type="radio" class="btn-check" name="package_id" value="{{$package->id}}"  id="kt_radio_buttons_2_option_{{$package->id}}"/>
                                    <label class="btn btn-outline btn-outline-dashed btn-light-primary p-4 d-flex align-items-center mb-3" for="kt_radio_buttons_2_option_{{$package->id}}">
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">Paketi Seç</span>
                            </span>
                                    </label>
                                    <!--end::Option-->

                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                        <!--end::Col-->
                    @endforeach


                </div>
                <!--end::Row-->
            </div>
            <div class="tab-pane fade" id="yearly_package_tab" role="tabpanel">
                <!--begin::Row-->
                <div class="row g-10">
                    @foreach($yearlyPackages as $package)
                        <!--begin::Col-->
                        <div class="col-xl-4">
                            <div class="d-flex h-100 align-items-center">
                                <!--begin::Option-->
                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-bolder">{{$package->name}}</h1>
                                        <!--end::Title-->

                                        <!--begin::Price-->
                                        <div class="text-center">
                                            <span class="mb-2 text-primary"></span>

                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
                                        {{$package->price ==  0 ? "Ücretsiz" : formatPrice($package->price)}}
                                    </span>
                                        </div>
                                        <!--end::Price-->
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Features-->
                                    <div class="w-100 mb-10">
                                        @php
                                            $propartieArray = $package->proparties->pluck('propartie_id')->toArray();
                                            $disabledProparies = $package->disabledProparties->pluck('propartie_id')->toArray();
                                        @endphp
                                        @foreach($proparties as $propartie)
                                            @if(!in_array($propartie->id, $disabledProparies))
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center mb-5">
                                              <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                  {{$propartie->name}}
                                              </span>
                                                    @if(in_array($propartie->id, $propartieArray))
                                                        <i class="ki-duotone ki-check-circle fs-1 text-success">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    @else
                                                        <i class="ki-duotone ki-cross-circle fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    @endif

                                                </div>
                                                <!--end::Item-->
                                            @endif
                                        @endforeach


                                    </div>
                                    <!--end::Features-->

                                    <!--begin::Option-->
                                    <input type="radio" class="btn-check" name="package_id" value="{{$package->id}}"  id="kt_radio_buttons_2_option_{{$package->id}}"/>
                                    <label class="btn btn-outline btn-outline-dashed btn-light-primary p-4 d-flex align-items-center mb-3" for="kt_radio_buttons_2_option_{{$package->id}}">
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">Paketi Seç</span>
                            </span>
                                    </label>
                                    <!--end::Option-->

                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                        <!--end::Col-->
                    @endforeach


                </div>
                <!--end::Row-->
            </div>
        </div>


    </div>
    <!--end::Plans-->
</div>
