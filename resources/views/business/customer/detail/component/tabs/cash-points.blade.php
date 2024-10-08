<!--begin:::Tab pane-->
<div class="tab-pane fade" id="kt_ecommerce_customer_cashpoint" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        @can('customer.cashpoint.show')
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Parapuanları</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="kt_ecommerce_customer_comments" class="card-body pt-0 pb-5">
            <!--begin::Addresses-->
            <div class="m-0" id="cashPointContainer">

            </div>
            <!--end::Addresses-->
        </div>
        <!--end::Card body-->
        @else
            <div class="card-body">
                <x-forbidden-component title="Yetkisiz Erişim" message="Müşteri Parapuanlarını Görüntülemek için yetkiniz bulunmamaktadır"></x-forbidden-component>
            </div>
        @endcan
    </div>
    <!--end::Card-->

</div>
<!--end:::Tab pane-->
