<!--begin::Aside column-->
<div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">

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
    </div>
    <!--end::Order details-->
</div>
<!--end::Aside column-->
