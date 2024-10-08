<div class="col-xl-4 mb-2">

    <!--begin::Statistics Widget 5-->
    <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg');background-size: cover">
        <!--begin::Body-->
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ki-duotone ki-basket text-white fs-2x ms-n1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <span class="fw-bold fs-1 text-white">{{formatPrice($todayCiro)}}</span>
            </div>

            <div class="text-white fw-bold fs-2 mb-2 mt-5">
                Günlük Ciro
            </div>

            <div class="fw-semibold text-white">
                Bugün Yapmış Olduğunuz Ciro
            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-xl-4 mb-2">

    <!--begin::Statistics Widget 5-->
    <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #484286;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg');background-size: cover">
        <!--begin::Body-->
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ki-duotone ki-cheque text-white fs-2x ms-n1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                    <span class="path6"></span>
                    <span class="path7"></span>
                </i>
                <span class="fw-bold fs-1 text-white">{{formatPrice($todayCosts)}}</span>

            </div>


            <div class="text-white fw-bold fs-2 mb-2 mt-5">
                Giderler
            </div>

            <div class="fw-semibold text-white">
                Bugünkü Giderler
            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>

<div class="col-xl-4 mb-2">

    <!--begin::Statistics Widget 5-->
    <a href="#" class="card hoverable card-xl-stretch mb-5 mb-xl-8" style="background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg');background-size: cover">
        <!--begin::Body-->
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ki-duotone ki-chart-simple-3 text-white fs-2x ms-n1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <span class="fw-bold fs-1 text-white">{{formatPrice($todayCiro - $todayCosts)}}</span>

            </div>


            <div class="text-white fw-bold fs-2 mb-2 mt-5">
                Kasa
            </div>

            <div class="fw-semibold text-white">
                Bugünkü Kasa
            </div>
        </div>
        <!--end::Body-->
    </a>
    <!--end::Statistics Widget 5-->
</div>
<!--end::Row-->
<a class="btn btn-flex btn-color-primary d-flex flex-stack fs-base p-0 ms-2 mb-2 mb-7 toggle collapsible collapsed" data-bs-toggle="collapse" href="#kt_app_dashboards_collapse" data-kt-toggle-text="Daha Az">
    <span data-kt-toggle-text-target="true">6 Diğer İstatistikler</span>
    <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
    <span class="svg-icon toggle-on svg-icon-2 me-0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																<rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
															</svg>
														</span>
    <!--end::Svg Icon-->
    <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
    <span class="svg-icon toggle-off svg-icon-2 me-0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
																<rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
																<rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
															</svg>
														</span>
    <!--end::Svg Icon-->
</a>
<div class="flex-row row collapse" id="kt_app_dashboards_collapse">
    @include('business.dashboard.parts.other-charts')
</div>


<div class="card card-xl-stretch mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Randevu ve Satış Grafiği</span>

            <span class="text-muted fw-semibold fs-7">Aylara Göre Randevu ve Satış Grafiğiniz</span>
        </h3>
        <!--end::Title-->

        {{--
            <!--begin::Toolbar-->
        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-duotone ki-category fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>            </button>


            <!--begin::Menu 1-->
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_64f9fda5a9b63">
                <!--begin::Header-->
                <div class="px-7 py-5">
                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                </div>
                <!--end::Header-->

                <!--begin::Menu separator-->
                <div class="separator border-gray-200"></div>
                <!--end::Menu separator-->


                <!--begin::Form-->
                <div class="px-7 py-5">
                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">Status:</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <div>
                            <select class="form-select form-select-solid" multiple="" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_64f9fda5a9b63" data-allow-clear="true">
                                <option></option>
                                <option value="1">Approved</option>
                                <option value="2">Pending</option>
                                <option value="2">In Process</option>
                                <option value="2">Rejected</option>
                            </select>
                        </div>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">Member Type:</label>
                        <!--end::Label-->

                        <!--begin::Options-->
                        <div class="d-flex">
                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                <input class="form-check-input" type="checkbox" value="1">
                                <span class="form-check-label">
                Author
            </span>
                            </label>
                            <!--end::Options-->

                            <!--begin::Options-->
                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="2" checked="checked">
                                <span class="form-check-label">
                Customer
            </span>
                            </label>
                            <!--end::Options-->
                        </div>
                        <!--end::Options-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold">Notifications:</label>
                        <!--end::Label-->

                        <!--begin::Switch-->
                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="" name="notifications" checked="">
                            <label class="form-check-label">
                                Enabled
                            </label>
                        </div>
                        <!--end::Switch-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end">
                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>

                        <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Menu 1-->            <!--end::Menu-->
        </div>
        <!--end::Toolbar-->
        --}}
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Chart-->
        <div id="kt_charts_widget_1_chart_new" style="height: 350px"></div>
        <!--end::Chart-->
    </div>
    <!--end::Body-->
</div>


<!--end::Row-->
<!--begin::Appointment Calendar-->
{{--
@include('business.dashboard.parts.calendar')

--}}
<!--end::Col-->

