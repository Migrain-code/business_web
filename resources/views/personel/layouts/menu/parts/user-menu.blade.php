<!--begin::User menu-->
<div class="app-navbar-item ms-5" id="kt_header_user_menu_toggle">
    <!--begin::Menu wrapper-->
    <div class="cursor-pointer symbol symbol-35px symbol-md-40px"
         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
         data-kt-menu-placement="bottom-end">
        <img class="symbol symbol-35px symbol-md-40px" src="{{image(authUser()->image)}}" alt="user">
    </div>

    <!--begin::User account menu-->
    <div
        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
        data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo" src="{{image(authUser()->image)}}">
                </div>
                <!--end::Avatar-->

                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">
                        {{authUser()->name}}
                        @if(authUser()->is_case == 1)
                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Kasa</span>
                        @else
                            <span class="badge badge-light-warning fw-bold fs-8 px-2 py-1 ms-2">Personel</span>
                        @endif
                    </div>

                    <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                        {{authUser()->phone}} </a>
                </div>
                <!--end::Username-->
            </div>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('personel.home')}}" class="menu-link px-5">
                Profilim
            </a>
        </div>

        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
             data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
            <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">
                                            Mode

                                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                <i class="ki-duotone ki-night-day theme-light-show fs-2"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span><span
                                                        class="path5"></span><span class="path6"></span><span
                                                        class="path7"></span><span class="path8"></span><span
                                                        class="path9"></span><span class="path10"></span></i>                        <i
                                                    class="ki-duotone ki-moon theme-dark-show fs-2"><span
                                                        class="path1"></span><span class="path2"></span></i>                    </span>
                                        </span>
            </a>

            <!--begin::Menu-->
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                data-kt-menu="true" data-kt-element="theme-mode-menu">
                <!--begin::Menu item-->
                <div class="menu-item px-3 my-0">
                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                       data-kt-value="light">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-duotone ki-night-day fs-2"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span><span
                                                class="path6"></span><span class="path7"></span><span
                                                class="path8"></span><span class="path9"></span><span
                                                class="path10"></span></i>            </span>
                        <span class="menu-title">
                                        Light
                                    </span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3 my-0">
                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>            </span>
                        <span class="menu-title">
                                        Dark
                                    </span>
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3 my-0">
                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                       data-kt-value="system">
                                    <span class="menu-icon" data-kt-element="icon">
                                        <i class="ki-duotone ki-screen fs-2"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>            </span>
                        <span class="menu-title">
                                        System
                                    </span>
                    </a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu-->

        </div>
        <!--end::Menu item-->

        {{--
            @include('personel.layouts.menu.parts.language')
        --}}

        <!--begin::Menu item-->
        <div class="menu-item px-5 my-1">
            <a href="{{route('personel.settings')}}" class="menu-link px-5">
                Hesap Ayarlarım
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5 my-1">
            <a href="{{route('personel.notificationPermission')}}" class="menu-link px-5">
                Bildirim İzinleri
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="javascript:void(0)" onclick="$('#logoutForm').submit()" class="menu-link px-5">
                Çıkış Yap
            </a>
        </div>
        <form type="hidden" method="post" id="logoutForm" action="{{route('personel.logout')}}">
            @csrf
        </form>
        <!--end::Menu item-->
    </div>
    <!--end::User account menu-->

    <!--end::Menu wrapper-->
</div>
<!--end::User menu-->