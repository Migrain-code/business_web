<!--begin::Aside column-->
<div class="w-100 flex-lg-row-auto mb-7 me-7 me-lg-10">

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
                    <label class="required form-label">Ödeme Yöntemi Seçiniz</label>
                    <!--end::Label-->

                    <!--begin::Select2-->
                    <select name="payment_type" id="payment_type_select" aria-label="Ödeme Yöntemi Seçiniz" data-control="select2" data-placeholder="Ödeme Yöntemi..."  class="form-select form-select-solid fw-bold">
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
                    <label class="required form-label">Personel Seçiniz</label>
                    <!--end::Label-->

                    <!--begin::Select2-->
                    <select name="personel_id" id="personel_select" aria-label="Personel Seçiniz" data-control="select2" data-placeholder="Personel Seçiniz..."  class="form-select form-select-solid fw-bold">
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
                    <select name="customer_id" id="customer_select" aria-label="Müşteri Seçiniz" data-control="select2" data-placeholder="Müşteri Seçiniz..."  class="form-select form-select-solid fw-bold">
                        <option value=""></option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->customer_id}}" @selected($customer->customer_id == $sale->customer_id)>{{$customer->customer->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Ürün Seçiniz</label>
                    <!--end::Label-->
                    <select name="product_id" id="product_id" aria-label="Ürün Seçiniz" data-control="select2" data-placeholder="Ürün Seçiniz..."  class="form-select form-select-solid fw-bold">

                        <option value=""></option>
                        @foreach($products as $row)
                            <option value="{{$row->id}}" @selected($row->id == $sale->product_id)>{{$row->name}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Adet</label>
                    <!--end::Label-->

                    <!--begin::Editor-->
                    <input type="number" name="amount" placeholder="Kaç Adet Ürün Satıldı Örn. 5" class="form-control mb-2" value="{{$sale->piece}}">
                    <!--end::Editor-->

                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="required form-label">Fiyat</label>
                    <!--end::Label-->

                    <!--begin::Editor-->
                    <input type="number" name="price" placeholder="Satılan Ürünlerin Toplam Fiyatı" class="form-control mb-2" value="{{$sale->total}}">
                    <!--end::Editor-->

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
                <!--end::Input group-->
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
                    Satış Yapılıyor... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Order details-->
</div>
<!--end::Aside column-->
