<div class="tab-pane fade" id="kt_ecommerce_adission_collection" role="tab-panel">
    <!--begin::Row-->
    <div class="card pt-4 mb-6 mb-xl-9 border-0">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="" style="display: block;">
                <h2 style="margin-bottom: 10px;margin-top: 5px;">Tahsilatlar</h2>
            </div>
            <div class="d-flex align-items-center">
                <!--begin::Filter-->
                <div class="w-150px me-3">
                    <!--begin::Select2-->
                    <select name="listTypePayment" class="form-select form-select-solid" data-control="select2"
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
                <div id="kt_ecommerce_report_customer_payment_export">

                </div>
                <button type="button" data-bs-toggle="modal" onclick="createCollection()"
                        data-bs-target="#kt_modal_add_payment" style="padding: 10px 20px !important;" class="btn btn-primary me-2">
                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Tahsilat Ekle
                </button>
                <!--begin::Export dropdown-->
                <button type="button" style="padding: 10px 20px !important;" class="btn btn-light-primary"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Rapor
                </button>
                <!--begin::Menu-->
                <div id="kt_ecommerce_report_customer_orders_export_menu_payment"
                     class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                     data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-payment="copy">
                            Panoya Kopyala
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-payment="excel">
                            Excel
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-payment="csv">
                            CSV
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-payment="pdf">
                            PDF
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3" data-kt-ecommerce-export-payment="print">
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
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="paymentDataTable">
                    <thead>
                    <tr>
                        <td class="min-w-125px">Ödeme Tarihi</td>
                        <td class="min-w-125px">Ödenen Tutar</td>
                        <td class="min-w-125px">Ödeme Kategori</td>
                        <td class="min-w-125px">Ödeme Tipi</td>
                        <td class="min-w-125px"> İşlemler </td>
                    </tr>
                    </thead>
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-semibold text-gray-600" id="paymentTable">
                        @foreach($appointment->payments as $payed)
                        <tr>
                            <td class="min-w-125px">{{$payed->created_at->format('d.m.Y H:i:s')}}</td>
                            <td class="min-w-125px">{{$payed->price}}₺</td>
                            <td class="min-w-125px">Adisyon Tahsilatı</td>
                            <td class="min-w-125px">{{$payed->type("name")}}</td>
                            <td>

                                <a class="btn btn-clean btn-sm btn-icon btn-icon-danger btn-active-light-danger ms-auto delete-btn" href="#" data-toggle="popover"
                                   data-object-id="{{$payed->id}}"
                                   data-route="{{'/personel/adission/'.$appointment->id.'/payment/'.$payed->id}}"
                                   data-model="App\Models\AppointmentCollectionEntry"
                                   data-delete-type="1"
                                   data-reload="true"
                                   data-content="Tahsilat Kaydını Silmek İstediğinize Eminmisiniz?"
                                   data-title="Tahilat">
                                    <i class="ki-duotone ki-trash fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Row-->

</div>
