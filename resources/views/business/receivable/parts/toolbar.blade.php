<!--begin::Card toolbar-->
<div class="card-toolbar">
    <!--begin::Toolbar-->
    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
        <!--begin::Filter-->
        <div class="w-150px me-3">
            <!--begin::Select2-->
            <select class="form-select form-select-solid" data-control="select2"
                    data-hide-search="true" data-placeholder="Alacak Seçiniz"
                    data-kt-ecommerce-order-filter="status">
                <option></option>
                <option value="all">Tümü</option>
                <option value="all">asdasd</option>
                <option value="all">ad</option>

            </select>
            <!--end::Select2-->
        </div>
        <!--end::Filter-->

        <!--begin::Add customer-->
        <button type="button" class="btn btn-primary me-1" data-bs-toggle="modal"
                data-bs-target="#kt_modal_add_customer">
            Alacak Ekle
        </button>

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

        </div>
        <!--end::Menu-->
        <!--end::Export-->
        <!--end::Add customer-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Group actions-->
    <div class="d-flex justify-content-end align-items-center d-none"
         data-kt-customer-table-toolbar="selected">
        <div class="fw-bold me-5">
               <span class="me-2" data-kt-customer-table-select="selected_count"></span> Seçildi
        </div>

        <button type="button" class="btn btn-danger"
                data-kt-customer-table-select="delete_selected">
            Seçilileri Sil
        </button>
    </div>
    <!--end::Group actions-->
</div>
<!--end::Card toolbar-->
