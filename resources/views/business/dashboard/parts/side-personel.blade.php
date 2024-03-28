<!--begin::Sidebar-->
<style>
    .customName {
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s linear 0.5s, opacity 0.3s linear;
    }
    a:hover .customName {
        visibility: visible;
        opacity: 1;
        transition-delay: 0s;
    }
</style>
<div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-navbar flex-grow-1 hover-scroll-overlay-y" id="kt_app_sidebar_primary_navbar" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_primary_footer" data-kt-scroll-wrappers="#kt_app_sidebar_primary_navbar" data-kt-scroll-offset="5px">
        <!--begin::Navbar-->
        <div class="app-navbar flex-column flex-center py-4" style="position: fixed;padding: 10px;">
            <!--begin::Navbar item-->
            <a href="pages/user-profile/overview.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-2.jpg" class="" alt="">
                </div>
                <div class="bg-dark customName" style="width: 230px;
                                    position: absolute;
                                    left: 52px;
                                    background-color: #1e1e2d !important;
                                    padding: 15px;
                                    border-top-right-radius: 15px;
                                    border-bottom-right-radius: 15px;
                                    border: 1px solid #1e1e2D;">
                    Muhammet Türkmen
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="account/billing.html" class="btn btn-icon btn-default mx-auto mb-4 active">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-7.jpg" class="" alt="">
                </div>
                <div class="bg-dark customName" style="width: 230px;
                                    position: absolute;
                                    left: 52px;
                                    background-color: #1e1e2d !important;
                                    padding: 15px;
                                    border-top-right-radius: 15px;
                                    border-bottom-right-radius: 15px;
                                    border: 1px solid #1e1e2D;">
                    Muhammet Türkmen
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="account/activity.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-10.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="account/overview.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-1.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="account/settings.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-3.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="apps/projects/users.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-21.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="apps/projects/targets.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-6.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="apps/projects/files.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-13.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->
            <!--begin::Navbar item-->
            <a href="apps/user-management/users/list.html" class="btn btn-icon btn-default mx-auto mb-4 ">
                <div class="symbol symbol-40px">
                    <img src="/business/assets/media/avatars/300-20.jpg" class="" alt="">
                </div>
            </a>
            <!--end::Navbar item-->

            <!--begin::Separator-->
            <div class="separator mb-4 border-gray-300 mx-5"></div>
            <!--end::Separator-->

            <!--begin::Navbar item-->
            <div class="app-navbar-item flex-center">
                <!--begin::Navbar link-->
                <a href="{{route('business.personel.create')}}" class="btn btn-icon btn-color-gray-600 bg-gray-200 btn-active-primary w-40px h-40px btn-accent">
                    <i class="ki-duotone ki-plus fs-1"></i>
                </a>
                <!--end::Navbar link-->
            </div>
            <!--end::Navbar item-->
        </div>
        <!--end::Navbar-->
    </div>
</div>
<!--end::Sidebar-->
