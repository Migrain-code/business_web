<!--begin::Aside column-->
<div class="col-12 mb-4">

    <!--begin::Order details-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <div class="card-title">
                <h2>Ürün Satışı</h2>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <div class="d-flex flex-column gap-3">


                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Personel Seçiniz</label>
                    <!--end::Label-->

                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                            data-placeholder="Personel Seçiniz" name="personel_id" id="kt_ecommerce_edit_order_shipping">
                        <option value=""></option>
                        @foreach($personels as $personel)
                            <option value="{{$personel->id}}" @selected($personel->id == $sale->personel_id)>{{$personel->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Müşteri Seçiniz</label>
                    <!--end::Label-->

                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                            data-placeholder="Müşteri Seçiniz" name="customer_id" id="kt_ecommerce_edit_order_customer">
                        <option value=""></option>
                        @foreach($customers as $row)
                            <option value="{{$row->customer_id}}" @selected($row->customer_id == $sale->customer_id)>{{$row->customer->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Ödeme Yöntemi Seçiniz</label>
                    <!--end::Label-->

                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                            data-placeholder="Ödeme Yöntemi Seçiniz" name="payment_type" id="kt_ecommerce_edit_order_payment">
                        <option></option>
                        @foreach($paymentMethods as $row)
                            <option value="{{$row['id']}}" @selected($row["id"] == $sale->payment_type)>{{$row['name']}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Tarih</label>
                    <!--end::Label-->

                    <!--begin::Editor-->
                    <input id="kt_ecommerce_edit_order_date" name="seller_date" placeholder="Tarih Seçiniz" class="form-control mb-2" value="{{$sale->created_at}}">
                    <!--end::Editor-->

                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Notunuz</label>
                    <!--end::Label-->

                    <!--begin::Editor-->
                    <textarea name="note" placeholder="Not" rows="7" class="form-control mb-2">{{$sale->note}}</textarea>
                    <!--end::Editor-->

                </div>
                <input type="hidden" id="productSaleId" value="{{$sale->id}}">

                <!--end::Input group-->
            </div>
        </div>
        <!--end::Card header-->
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
                    Ürün Satışını Güncelle
                </span>
                        <span class="indicator-progress">
                    Satış Güncelleniyor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                    </button>
                    <!--end::Button-->
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">

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
                                    <input class="form-check-input tableCheckBox @if($product->id == $sale->product_id) selectedProductChecked @endif" type="checkbox" value="{{$product->id}}">
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
                                                <input type="number" style="display: none" class="form-control qtyCounter"
                                                       name="qty[{{$product->id}}]"
                                                       data-kt-ecommerce-edit-order-filter="qty" min="1"
                                                       max="{{$product->piece}}"
                                                       value="{{$sale->piece}}">
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
                <!--begin::Separator-->
                <div class="separator"></div>
                <!--end::Separator-->

                <div class="d-flex flex-column gap-10">
                    <!--begin::Input group-->
                    <div>
                        <!--begin::Label-->
                        <label class="form-label badge badge-light-warning">Not: Ürün satışı güncellemede ürün değişikliği yapabilirsiniz. Fakat 1'den fazla ürün seçemezsiniz.</label>
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
                            <div class="d-flex justify-content-between mx-4">
                                <div class="col" style="max-width: 250px">
                                    <div class="form-group">
                                        <label>İndirim Uygula</label>
                                        <input type="number" name="discount" class="form-control" placeholder="Örn. (15)" value="{{($sale->product->price * $sale->piece) - $sale->total}}" min="1">
                                    </div>
                                </div>
                                <div class="col" style="text-align: right">
                                    Toplam Tutar : <br>
                                    <span id="kt_ecommerce_edit_order_total_price">0,00</span> ₺ <br>
                                    Uygulanacak İndirim : <br>
                                    <span id="kt_ecommerce_edit_order_total_price">{{formatPrice(($sale->product->price * $sale->piece) - $sale->total)}}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Total price-->
                    </div>
                    <!--end::Input group-->


                </div>
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Order details-->
    </div>
    <!--end::Order details-->

</div>
<!--end::Aside column-->
