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
                        @if(authUser()->is_admin == 1)
                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Admin</span>
                        @else
                            <span class="badge badge-light-warning fw-bold fs-8 px-2 py-1 ms-2">Yetkili</span>
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
            <a href="{{route('business.official.setting')}}" class="menu-link px-5">
                Profilim
            </a>
        </div>
        <!--end::Menu item-->
        @can('businessSettings.list')
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('business.settings')}}" class="menu-link px-5">
                İşletme Bilgileri
            </a>
        </div>
        @endcan
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{env('REMOTE_URL').authUser()->business->slug}}" class="menu-link px-5">
                Salona Git
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('business.setup.setSetup')}}" class="menu-link px-5">
                Kuruluma Git
            </a>
        </div>
        <!--end::Menu item-->
        @if(authUser()->is_admin == 1)
            @can('branche.list')
            <div class="menu-item px-5">
                <a href="{{route('business.branche.index')}}" class="menu-link px-5">
                    <span class="menu-text">Şubeler</span>
                    <span class="menu-badge">
                                        <span class="badge badge-light-info badge-circle fw-bold fs-7">{{authUser()->business->branches->count()}}</span>
                                    </span>
                </a>
            </div>
            @endcan
        @endif
        <!--begin::Menu item-->
        @if(authUser()->is_admin == 1)
        <!--begin::Menu item-->
        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
             data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
            <a href="#" class="menu-link px-5">
                <span class="menu-title">Aboneliğim</span>
                <span class="menu-arrow"></span>
            </a>

            <!--begin::Menu sub-->
            <div class="menu-sub menu-sub-dropdown w-175px py-4">

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="{{route('business.invoice.index')}}" class="menu-link px-5">
                        Faturalar
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="{{route('business.subscription.index')}}" class="menu-link px-5">
                        Abonelik
                    </a>
                </div>
                <!--end::Menu item-->

                <!--begin::Menu separator-->
                <div class="separator my-2"></div>
                <!--end::Menu separator-->
            </div>
            <!--end::Menu sub-->
        </div>
        <!--end::Menu item-->
        @endif
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('business.notification-permission.index')}}" class="menu-link px-5">
                Bildirim İzinleri
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->


        {{--
            @include('business.layouts.menu.parts.language')
        --}}


        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="javascript:void(0)" onclick="$('#logoutForm').submit()" class="menu-link px-5">
                Çıkış Yap
            </a>
        </div>
        <form type="hidden" method="post" id="logoutForm" action="{{route('business.logout')}}">
            @csrf
        </form>
        <!--end::Menu item-->
    </div>
    <!--end::User account menu-->

    <!--end::Menu wrapper-->
</div>
<!--end::User menu-->
