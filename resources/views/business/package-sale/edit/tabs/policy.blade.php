<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_policy" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9 border-0">
        @can('packageSale.terms.list')
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title" style="display: block;">
                <h2 style="margin-bottom: 10px;margin-top: 5px;">Paket Sözleşmeleri</h2>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_policy" style="padding: 10px 20px !important;" class="btn btn-light-primary me-2">
                    <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Sözleşme Ekle
                </button>

            </div>
        </div>
        <div class="card-body pt-0 pb-5">
            <!--begin::Table wrapper-->
            @forelse($packageSale->policies as $policy)
                <div class="m-0" id="cashPointContainer">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center me-5">
                            <!--begin::Flag-->
                            <i class="fa fa-file me-4 w-30px fs-1" style="transform: rotate(35deg);"></i>
                            <!--end::Flag-->

                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">{{$policy->file_name}}</a>
                                <!--end::Title-->

                                <!--begin::Desc-->
                                <span class="text-gray-400 fw-semibold fs-6 d-block text-start fw-bold ps-0">{{$policy->created_at->format('d.m.Y H:i:s')}}</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->

                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">
                                <button type="button" class="btn btn-lg btn-icon btn-icon-primary btn-light-primary me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-3 svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor" opacity="0.3"></rect>
                                        </g>
                                    </svg>
                                </span>
                                    <!--end::Svg Icon-->
                            </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">
                                <!--begin::Heading-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">İşlemler</div>
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a class="btn btn-light-primary btn-sm w-100" href="/business/assets/media/product_Raporu.pdf" target="_blank"><i class="fa fa-eye"></i> Görüntüle</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a class="btn btn-light-warning btn-sm w-100 printFile" href="/business/assets/media/product_Raporu.pdf" data-file="/business/assets/media/product_Raporu.pdf" target="_blank"><i class="fa fa-print"></i> Yazdır</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                            </span>
                            <!--end::Number-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-4"></div>
                    <!--end::Separator-->

                </div>
            @empty
            @endforelse

        </div>
        @else
            <div class="card-body">
                <x-forbidden-component title="Yetkisiz Erişim" message="Pakete Sözleşme Eklemek, Listelemek ve silmek için yetkiniz bulunmamaktadır"></x-forbidden-component>
            </div>
        @endcan
        <!--end::Card body-->
    </div>
</div>
<!--end:::Tab pane-->
