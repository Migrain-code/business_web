<!--begin::Navbar-->
<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <!--begin::Image-->
            <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4" id="personelProfileImage">
                <img class="w-100 rounded" src="{{image($personel->image)}}" alt="image">
            </div>
            <!--end::Image-->

            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{$personel->name}}</a>
                            @if($personel->safe == 0)
                                <span class="badge badge-light-warning me-auto">Personel</span>
                            @else
                                <span class="badge badge-light-success me-auto">Kasa</span>
                            @endif
                        </div>
                        <!--end::Status-->

                        <!--begin::Description-->
                        @if($personel->safe == 1)
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                                Bu personele kasa erişim yetkisi verdiniz.
                            </div>
                        @endif

                        <!--end::Description-->
                    </div>
                    <!--end::Details-->

                    <!--begin::Actions-->
                    <div class="d-flex mb-4">
                        <!--begin::Menu-->
                        <div class="me-0">
                            <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-solid ki-dots-horizontal fs-2x"></i>                            </button>

                            <!--begin::Menu 3-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                        Payments
                                    </div>
                                </div>
                                <!--end::Heading-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Create Invoice
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link flex-stack px-3">
                                        Create Payment

                                        <span class="ms-2" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference">
                <i class="ki-duotone ki-information fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>            </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">
                                        Generate Bill
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-title">Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>

                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Plans
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Billing
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                Statements
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3">
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications">
                                                    <!--end::Input-->

                                                    <!--end::Label-->
                                                    <span class="form-check-label text-muted fs-6">
                            Recuring
                        </span>
                                                    <!--end::Label-->
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-1">
                                    <a href="#" class="menu-link px-3">
                                        Settings
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Head-->

                <!--begin::Info-->
                <div class="d-flex flex-wrap justify-content-start">
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">{{$personel->created_at->translatedFormat('d F, Y')}}</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-400">Kayıt Tarihi</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-calendar fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="{{$personel->appointments->count()}}">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-400">Toplam Randevu</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-wallet fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="{{$personel->insideBalance()}}" data-kt-countup-prefix="₺">{{$personel->insideBalance()}}</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-400">İçerideki Bakiye</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->
                    </div>
                    <!--end::Stats-->

                </div>
                <!--end::Info-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Details-->

        <div class="separator"></div>

        <div class="p-5">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-gray-100 hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-chart-simple text-danger fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>

                            <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">
                               {{formatPrice($personel->totalBalance())}}
                            </div>

                            <div class="fw-semibold text-gray-400">
                                Toplam Yapılan Kazanç
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-cheque text-gray-100 fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></i>

                            <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">
                                {{$personel->getCustomer()}}
                            </div>

                            <div class="fw-semibold text-gray-100">
                                Müşteriye Hizmet verildi
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-briefcase text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>

                            <div class="text-white fw-bold fs-2 mb-2 mt-5">
                                {{$personel->appointments->count()}}
                            </div>

                            <div class="fw-semibold text-white">
                                İşlemde Hizmet Verdi
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">

                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <i class="ki-duotone ki-chart-pie-simple text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>

                            <div class="text-white fw-bold fs-2 mb-2 mt-5">
                               {{formatPrice($personel->insideBalance())}}
                            </div>

                            <div class="fw-semibold text-white">
                               İçeride Kalan Bakiye
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>
        </div>

        <div class="separator"></div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6  active" data-bs-toggle="tab" href="#kt_ecommerce_personel_overview" role="tab">
                    Önizleme
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 appointmentTab" data-bs-toggle="tab" href="#kt_ecommerce_personel_appointment" role="tab">
                    Randevular
                </a>
            </li>
            <!--end::Nav item-->
        </ul>

    </div>
</div>
<!--end::Navbar-->
