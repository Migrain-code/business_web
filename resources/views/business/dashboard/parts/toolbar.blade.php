<div id="kt_app_toolbar" class="app-toolbar ">

    <!--begin::Toolbar container-->
    <div class="d-flex flex-stack flex-row-fluid">
        <!--begin::Toolbar wrapper-->
        <div class="d-flex flex-column flex-row-fluid">

            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3">

                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
                    <a href="index.html" class="text-white text-hover-primary">
                        <i class="ki-duotone ki-home text-gray-500 fs-2"></i> </a>
                </li>
                <!--end::Item-->

                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
                <!--end::Item-->


                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
                    Dashboards
                </li>
                <!--end::Item-->


            </ul>
            <!--end::Breadcrumb-->


            <!--begin::Page title-->
            <div class="page-title d-flex align-items-center me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bolder fs-1 flex-column justify-content-center my-0">
                    {{authUser()->name}}
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar wrapper-->

    </div>
    <!--end::Toolbar container-->    </div>
