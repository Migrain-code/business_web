<!--begin::Card toolbar-->
<div class="card-toolbar">
    <!--begin::Toolbar-->
    <div class="d-flex justify-content-end align-items-center w-100" data-kt-customer-table-toolbar="base">
        <!--begin::Filter-->
        <div class="d-flex w-400px gap-2 me-2">
            <!--begin::Select2-->
            <select id="listType" class="form-select form-select-solid" data-control="select2"
                    data-hide-search="true" data-placeholder="Tarih Seçiniz"
                    data-kt-ecommerce-order-filter="status">
                <option></option>
                <option value="all">Tümü</option>
                <option value="thisDay">Bu Gün</option>
                <option value="thisWeek">Bu Hafta</option>
                <option value="thisMonth">Bu Ay</option>
                <option value="thisYear">Bu Yıl</option>
            </select>
            <select id="stockType" class="form-select form-select-solid" data-control="select2"
                    data-hide-search="true" data-placeholder="Stok Durumu">
                <option></option>
                <option value="all">Tümü</option>
                <option value="outStock">Stoğu Tükenmiş</option>
                <option value="midStock">Az Kalmış</option>
                <option value="inStock">Stokta</option>

            </select>


            <!--end::Select2-->
        </div>

        <!--end::Filter-->

        <!--begin::Add customer-->
        <a href="#" type="button" class="btn btn-primary me-1" data-bs-toggle="modal"
           data-bs-target="#kt_modal_add_customer">
            Ürün Ekle
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
