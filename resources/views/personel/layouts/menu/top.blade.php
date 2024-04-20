<!--begin::Header-->
<div id="kt_app_header" class="app-header ">

    <div class="app-container  container-fluid d-flex align-items-stretch justify-content-between " style="height: 70px"
         id="kt_app_header_container">
        <!--begin::Header mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-color-white btn-active-color-primary w-35px h-35px"
                 id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
        <!--end::Header mobile toggle-->

        <!--begin::Logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-5 me-lg-0">
            <a href="{{route('business.home')}}">
                <img alt="Logo" src="/business/assets/media/logos/demo46.svg"
                     class="d-none d-sm-block">
                <img alt="Logo" src="/business/assets/media/logos/demo46.svg" class="d-block d-sm-none">
            </a>
        </div>
        <!--end::Logo-->

        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                 data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                 data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                 data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                 data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                 data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <!--begin::Menu-->
                <div class=" menu
                                    menu-rounded
                                    menu-active-bg
                                    menu-state-primary
                                    menu-column
                                    menu-lg-row
                                    menu-title-gray-700
                                    menu-icon-gray-500
                                    menu-arrow-gray-500
                                    menu-bullet-gray-500
                                    my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0
                                " id="kt_app_header_menu" data-kt-menu="true">
                    <!--begin:Menu item-->

                    <!--begin:Menu item-->

                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('personel.home')}}">
                        <span class="menu-link">
                            <span class="menu-title">Hesap Özeti</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>
                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('personel.appointments')}}">
                        <span class="menu-link">
                            <span class="menu-title">Randevular</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>
                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('personel.personel-stay-off-day.index')}}">
                        <span class="menu-link">
                            <span class="menu-title">İzinler</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>
                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('business.adission.index')}}">
                        <span class="menu-link">
                            <span class="menu-title">Kasa</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>
                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('personel.payment.index')}}">
                        <span class="menu-link">
                            <span class="menu-title">Ödemeler</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>
                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('personel.notifications')}}">
                        <span class="menu-link">
                            <span class="menu-title">Bildirimler</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>
                    <a class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2" href="{{route('personel.settings')}}">
                        <span class="menu-link">
                            <span class="menu-title">Ayarlar</span>
                            <span class="menu-arrow d-lg-none"></span>
                        </span><!--end:Menu link--><!--begin:Menu sub-->

                    </a>

                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu wrapper-->

            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">

                <!--begin::Notifications-->
                <div class="app-navbar-item ms-1 ms-lg-3">
                    <!--begin::Menu- wrapper-->
                    <div
                        class="btn btn-icon btn-custom btn-color-white btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-notification-on fs-1"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true"
                         id="kt_menu_notifications">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column bgi-no-repeat rounded-top"
                             style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                            <!--begin::Title-->
                            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                                Notifications <span class="fs-8 opacity-75 ps-3">24 reports</span>
                            </h3>
                            <!--end::Title-->

                            <!--begin::Tabs-->
                            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                                       data-bs-toggle="tab" href="#kt_topbar_notifications_1">Bildirimler</a>
                                </li>

                            </ul>
                            <!--end::Tabs-->
                        </div>
                        <!--end::Heading-->

                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab panel-->
                            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                                <!--begin::Items-->
                                <div class="scroll-y mh-325px my-5 px-8">
                                    @forelse(authUser()->notificationMenu as $notification)
                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack py-4">
                                            <!--begin::Section-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-35px me-4">
                                                        <span class="symbol-label bg-light-primary">
                                                            <i class="ki-duotone ki-abstract-28 fs-2 text-primary"><span
                                                                    class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div class="mb-0 me-2">
                                                    <a href="javascript:void(0)" class="fs-6 text-gray-800 text-hover-primary fw-bold messageContentButton"
                                                       data-content="{{$notification->message}}"
                                                       data-title="{{$notification->title}}">
                                                        {{$notification->title}}
                                                    </a>
                                                    <div class="text-gray-400 fs-7">{{$notification->created_at->format('d.m.Y H:i')}}</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Section-->

                                            <!--begin::Label-->
                                            <span class="badge badge-light fs-8">{{$notification->created_at->diffForHumans()}}</span>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Item-->
                                    @empty
                                    @endforelse
                                </div>
                                <!--end::Items-->

                                <!--begin::View more-->
                                <div class="py-3 text-center border-top">
                                    <a href="{{route('personel.notifications')}}"
                                       class="btn btn-color-gray-600 btn-active-color-primary">
                                        Tümünü Göster
                                        <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span
                                                class="path2"></span></i> </a>
                                </div>
                                <!--end::View more-->
                            </div>
                            <!--end::Tab panel-->
                        </div>
                        <!--end::Tab content-->
                    </div>
                    <!--end::Menu-->        <!--end::Menu wrapper-->
                </div>
                <!--end::Notifications-->

                <!--begin::Quick links-->
                <div class="app-navbar-item ms-1 ms-lg-3">
                    <!--begin::Menu- wrapper-->
                    <div
                        class="btn btn-icon btn-custom btn-color-white btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-rocket fs-2"><span class="path1"></span><span class="path2"></span></i>

                    </div>

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10"
                             style="background-image:url('/business/assets/media/misc/menu-header-bg.jpg')">
                            <!--begin::Title-->
                            <h3 class="text-white fw-semibold mb-3">
                                Hızlı Linkler
                            </h3>
                            <!--end::Title-->

                            <!--begin::Status-->
                            <span class="badge bg-primary text-inverse-primary py-2 px-3">6 Hızlı İşlem</span>
                            <!--end::Status-->
                        </div>
                        <!--end::Heading-->

                        <!--begin:Nav-->
                        <div class="row g-0">
                            <!--begin:Item-->
                            <div class="col-6">
                                <a href="{{route('personel.case.index')}}"
                                   class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                    <i class="ki-duotone ki-wallet fs-3x text-primary mb-2"><span
                                            class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    <span class="fs-5 fw-semibold text-gray-800 mb-0">Kasa</span>
                                    <span class="fs-7 text-gray-400">Personel Kasası</span>
                                </a>
                            </div>
                            <!--end:Item-->

                            <!--begin:Item-->
                            <div class="col-6">
                                <a href="{{route('personel.appointmentCreate.index')}}"
                                   class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                                    <i class="ki-duotone ki-abstract-41 fs-3x text-primary mb-2"><span
                                            class="path1"></span><span class="path2"></span></i> <span
                                        class="fs-5 fw-semibold text-gray-800 mb-0">Yeni Randevu</span>
                                    <span class="fs-7 text-gray-400">Randevular</span>
                                </a>
                            </div>
                            <!--end:Item-->
                        </div>
                        <!--end:Nav-->

                        {{--
                            <!--begin::View more-->
                        <div class="py-2 text-center border-top">
                            <a href="pages/user-profile/activity.html"
                               class="btn btn-color-gray-600 btn-active-color-primary">
                                View All
                                <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span
                                        class="path2"></span></i> </a>
                        </div>
                        <!--end::View more-->
                        --}}
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::Quick links-->

                @include('personel.layouts.menu.parts.user-menu')

                <!--begin::Header menu toggle-->
                <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
                    <div class="btn btn-icon btn-color-white btn-active-color-primary w-30px h-30px w-md-35px h-md-35px"
                         id="kt_app_header_menu_toggle">
                        <i class="ki-duotone ki-text-align-left fs-2 fs-md-1 fw-bold"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span><span class="path4"></span></i></div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->
