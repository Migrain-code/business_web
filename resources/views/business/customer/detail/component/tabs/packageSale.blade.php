<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_packageSale" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        @can('customer.packageSale.show')
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Paket Satışları</h2>
            </div>
            <div class="d-flex align-items-center">
                <!--begin::Filter-->
                <div class="w-150px me-3">
                    <!--begin::Select2-->
                    <select name="listTypePackage" class="form-select form-select-solid" data-control="select2"
                            data-hide-search="true" data-placeholder="Tarih Aralığı"
                            data-kt-ecommerce-order-filter="status">
                        <option></option>
                        <option value="all">Tümü</option>
                        <option value="thisWeek">Bu Hafta</option>
                        <option value="thisMonth">Bu Ay</option>
                        <option value="thisYear">Bu Yıl</option>
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Filter-->
                <div id="kt_ecommerce_report_customer_packages_export">

                </div>
                <!--begin::Export dropdown-->
                <button type="button" style="padding: 10px 20px !important;" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Rapor
                </button>
                <!--begin::Menu-->
                <div id="kt_ecommerce_report_customer_orders_export_menu_package" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-package="copy">
                            Panoya Kopyala
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-package="excel">
                            Excel
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-package="csv">
                            CSV
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-package="pdf">
                            PDF
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-package="print">
                            Yazdır
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
                <!--end::Export-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="packageSaleDataTable">
                    <thead>
                        <tr>
                            <td class="min-w-125px">Satış Tarihi</td>
                            <td class="min-w-125px">Hizmet</td>
                            <td class="min-w-125px">Miktar</td>
                            <td class="min-w-125px">Kullanılan</td>
                            <td class="min-w-125px">Kalan Kullanım</td>
                            <td class="min-w-125px">Toplam Tutar</td>
                            <td class="min-w-125px">Ödenen Tutar </td>
                            <td class="min-w-125px">Kalan Ödeme </td>
                        </tr>
                    </thead>
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-semibold text-gray-600" id="packageSaleTable">

                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
        @else
            <div class="card-body">
                <x-forbidden-component title="Yetkisiz Erişim" message="Müşteri Paket Satışlarını Görüntülemek için yetkiniz bulunmamaktadır"></x-forbidden-component>
            </div>
        @endcan
    </div>

</div>
<!--end:::Tab pane-->
