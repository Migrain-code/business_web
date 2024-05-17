<!--begin::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
    <!--begin::Orders-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <!--begin::Order history-->
        <div class="card card-flush py-4 flex-row-fluid">
            <!--begin::Card header-->
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Ürün Satış Listesi</h2>
                </div>
                <button type="button" class="btn btn-light-warning" onclick="fetchProductCreateInfos()" data-bs-toggle="modal" data-bs-target="#adission_add_product_sale_modal"><i class="fa fa-plus-circle me-2"></i> Yeni Ürün Satışı</button>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                #
                            </th>
                            <th class="min-w-125px">Satış Tarihi</th>
                            <th class="min-w-125px">Müşteri</th>
                            <th class="min-w-125px">Ürün</th>
                            <th class="min-w-125px">Satıcı</th>
                            <th class="min-w-125px">Adet</th>
                            <th class="min-w-125px">Toplam Tutar</th>
                            <th class="text-end min-w-70px">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Order history-->

    </div>
    <!--end::Orders-->
</div>
<!--end::Tab pane-->
