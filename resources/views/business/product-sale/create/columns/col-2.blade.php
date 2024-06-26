<!--begin::Main column-->
<div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">

    <!--begin::Order details-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Seçtiğiniz Ürünler</h2>
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <!--begin::Button-->
                <a href="{{route('business.sale.index')}}" id="kt_ecommerce_edit_order_cancel" class="btn btn-light me-5">
                    İptal Et
                </a>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                <span class="indicator-label">
                    Ürün Satışını Kaydet
                </span>
                    <span class="indicator-progress">
                    Satış Yapılıyor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="d-flex flex-column gap-10">
                <!--begin::Input group-->
                <div>
                    <!--begin::Label-->
                    <label class="form-label">Eklediğiniz Ürünler</label>
                    <!--end::Label-->

                    <!--begin::Selected products-->
                    <div class="row row-cols-1 row-cols-xl-3 row-cols-md-2 border border-dashed rounded pt-3 pb-1 px-2 mb-5 mh-300px overflow-scroll" id="kt_ecommerce_edit_order_selected_products">
                        <!--begin::Empty message-->
                        <span class="w-100 text-muted ">Onay kutusunu işaretleyerek aşağıdaki listeden bir veya daha fazla ürün seçin.</span>
                        <!--end::Empty message-->

                    </div>
                    <!--begin::Selected products-->

                    <!--begin::Total price-->
                    <div class="fw-bold fs-4">
                        <div class="d-flex justify-content-between">
                            <div class="col">
                                Toplam Tutar : <br>
                                <span id="kt_ecommerce_edit_order_total_price">0,00</span> ₺

                            </div>
                            <div class="col" style="max-width: 220px">
                                <div class="form-group">
                                    <label>İndirim Uygula</label>
                                    <input type="number" name="discount" class="form-control" placeholder="Örn. (15)" value="" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Total price-->
                </div>
                <!--end::Input group-->

                <!--begin::Separator-->
                <div class="separator"></div>
                <!--end::Separator-->

                <!--begin::Search products-->
                <div class="d-flex align-items-center position-relative mb-n7 ">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" data-kt-ecommerce-edit-order-filter="search"
                           class="form-control form-control-solid w-100 w-lg-50 ps-12"
                           placeholder="Ürünlerde Ara">
                </div>
                <!--end::Search products-->

                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="w-25px pe-2"></th>
                        <th class="min-w-200px">Ürün</th>
                        <th class="min-w-100px text-end pe-5">Stok Sayısı</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="{{$product->id}}">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center" data-kt-ecommerce-edit-order-filter="product" data-kt-ecommerce-edit-order-id="product_{{$product->id}}">
                                        <!--begin::Thumbnail-->
                                        <a href="" class="symbol symbol-50px">
                                            <span class="symbol-label">
                                                <i class="fa fa-cart-shopping"></i>
                                            </span>
                                        </a>
                                        <!--end::Thumbnail-->

                                        <div class="ms-5">
                                            <div class="d-flex align-items-center">
                                                <div class="col" style="min-width: 145px">
                                                    <!--begin::Title-->
                                                    <a href="../catalog/edit-product.html" class="text-gray-800 text-hover-primary fs-5 fw-bold ">
                                                        {{ucwords($product->name)}}
                                                    </a>
                                                    <!--end::Title-->

                                                    <!--begin::Price-->
                                                    <div class="fw-semibold fs-7">Fiyat: ₺
                                                        <span data-kt-ecommerce-edit-order-filter="price">{{$product->price}}</span>
                                                    </div>
                                                    <!--end::Price-->

                                                    <!--begin::SKU-->
                                                    <div class="text-muted fs-7">Barkod: {{$product->barcode}}</div>
                                                    <!--end::SKU-->
                                                </div>
                                                <div class="col">
                                                    <input type="number" style="display: none" class="form-control qtyCounter" name="qty[{{$product->id}}]" data-kt-ecommerce-edit-order-filter="qty" min="1" max="{{$product->piece}}" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-5" data-order="{{$product->piece}}">
                                    <span class="fw-bold ms-3">{{$product->piece}}</span>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <!--end::Table-->
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->

</div>
<!--end::Main column-->
