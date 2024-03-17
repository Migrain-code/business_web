<!--begin::Card toolbar-->
<div class="card-toolbar">
    <!--begin::Toolbar-->
    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
        <!--begin::Filter-->
        <div class="w-150px me-3">
            <!--begin::Select2-->
            <form method="get" action="" id="filterForm">
                <select id="listType" class="form-select form-select-solid" data-control="select2"
                        data-hide-search="true" data-placeholder="Status"
                        data-kt-ecommerce-order-filter="status">
                    <option></option>
                    <option value="all" selected>Tümü</option>
                    <option value="thisDay">Bu Gün</option>
                    <option value="thisWeek">Bu Hafta</option>
                    <option value="thisMonth">Bu Ay</option>
                    <option value="thisYear">Bu Yıl</option>
                </select>
            </form>

            <!--end::Select2-->
        </div>
        <!--end::Filter-->

        <!--begin::Add customer-->
        <a href="#" type="button" class="btn btn-primary me-1" data-bs-toggle="modal"
           data-bs-target="#kt_modal_add_customer">
            Yeni Paket Satışı
        </a>

        <!--begin::Export-->
        <!--begin::Export dropdown-->
        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
            Rapor
        </button>
        <!--begin::Menu-->
        <div id="kt_ecommerce_report_customer_orders_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="copy">
                    Panoya Kopyala
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="excel">
                    Excel
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="csv">
                    CSV
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="pdf">
                    PDF
                </a>
            </div>
            <!--end::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-ecommerce-export="print">
                    Yazdır
                </a>
            </div>
        </div>
        <!--end::Menu-->
        <!--end::Export-->
        <!--end::Add customer-->
    </div>
    <!--end::Toolbar-->


</div>
<!--end::Card toolbar-->
