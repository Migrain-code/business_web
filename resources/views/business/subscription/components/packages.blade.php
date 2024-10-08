<div class="@if(isset($package)) col-lg-8 @else col-lg-12 @endif ">
    <div class="card">
        <div class="card-body">
            <!--begin::Plans-->
            <div class="d-flex flex-column">
                <!--begin::Heading-->
                <div class="mb-13 text-center">
                    <h1 class="fs-2hx fw-bold mb-5">Planınızı Seçin</h1>
                    <div class="text-gray-400 fw-semibold fs-5">Fiyatlandırmamız hakkında daha fazla bilgiye ihtiyacınız varsa, lütfen kontrol edin
                        <a href="#" class="link-primary fw-bold">Fiyatlandırma Yönergeleri</a>.</div>
                </div>
                <!--end::Heading-->
                <!--begin::Nav group-->
                <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true">
                    <button class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active monthlyBtn" data-kt-plan="month">Aylık</button>
                    <button class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 yearlyBtn" data-kt-plan="annual">Yıllık</button>
                </div>
                <!--end::Nav group-->
                <!--begin::Row-->
                <div id="priceTab1" class="row g-10">
                    @foreach($monthlyPackages as $mPackage)
                        <!--begin::Col-->
                        <div class="@if(isset($package)) col-md-6 @else col-md-4 @endif ">
                            <div class="d-flex ">
                                <!--begin::Option-->
                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-bolder">{{$mPackage->name}}</h1>
                                        <!--end::Title-->
                                        <!--begin::Price-->
                                        <div class="text-center">

                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{$mPackage->price}}</span>
                                            <span class="mb-2 text-primary fs-3">₺</span>
                                            <span class="fs-7 fw-semibold opacity-50">/
																		<span data-kt-element="period">Ay</span></span>
                                        </div>
                                        <!--end::Price-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Features-->
                                    <div class="w-100 mb-10">
                                        @foreach($mPackage->proparties as $propartie)
                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{$propartie->list->name}}</span>
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                <span class="svg-icon svg-icon-1 svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Item-->
                                        @endforeach


                                    </div>
                                    <!--end::Features-->
                                    <!--begin::Select-->
                                    <a href="{{route('business.packet.buy', $mPackage->id)}}" class="btn btn-sm btn-primary">Bu Pakete Geç</a>
                                    <!--end::Select-->
                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                        <!--end::Col-->
                    @endforeach
                </div>
                <div id="priceTab2" class="row" style="display: none">
                    @foreach($yearlyPackages->where('type',1) as $yPackage)
                        <!--begin::Col-->
                        <div class="@if(isset($package)) col-md-6 @else col-md-4 @endif ">
                            <div class="d-flex ">
                                <!--begin::Option-->
                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-bolder">{{$yPackage->name}}</h1>
                                        <!--end::Title-->
                                        <!--begin::Price-->
                                        <div class="text-center">
                                            <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{$yPackage->price}}</span>
                                            <span class="mb-2 text-primary fs-3">₺</span>
                                            <span class="fs-7 fw-semibold opacity-50">/
																		<span data-kt-element="period">{{$yPackage->price == 0 ? "Ay" : "Yıl"}}</span></span>
                                        </div>
                                        <!--end::Price-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Features-->
                                    <div class="w-100 mb-10">
                                        @foreach($yPackage->proparties as $propartie)
                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-5">
                                                <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{$propartie->list->name}}</span>
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                <span class="svg-icon svg-icon-1 svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Item-->
                                        @endforeach


                                    </div>
                                    <!--end::Features-->
                                    <!--begin::Select-->
                                    <a href="{{route('business.packet.buy', $yPackage->id)}}" class="btn btn-sm btn-primary">Bu Pakete Geç</a>
                                    <!--end::Select-->
                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                        <!--end::Col-->
                    @endforeach
                </div>
                <!--end::Row-->
            </div>
            <!--end::Plans-->
        </div>
    </div>
</div>
