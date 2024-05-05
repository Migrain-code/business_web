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
            <a href="{{route('personel.settings', authUser()->id)}}" class="menu-link px-5">
                Profilim
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('personel.personel-stay-off-day.index')}}" class="menu-link px-5">
                İzinlerim
            </a>
        </div>

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('personel.notificationPermission')}}" class="menu-link px-5">
                Bildirim İzinleri
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->
        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{route('personel.notifications')}}" class="menu-link px-5">
                Bildirimler
            </a>
        </div>
        <!--begin::Menu item-->
        <div class="menu-item px-5 my-1">
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#kt_modal_password_update" class="menu-link px-5">
                Şifremi Değiştir
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
