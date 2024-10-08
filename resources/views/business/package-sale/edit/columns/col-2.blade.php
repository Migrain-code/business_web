<!--begin::Main column-->

<div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
    <div class="card card-flush py-4">

            <div class="card-header">
            <div class="">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active payments"
                               data-package="{{$packageSale->id}}" style="font-size: 1.25rem;" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_payments">Ödemeler</a>
                        </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 usages" data-package="{{$packageSale->id}}"
                               style="font-size: 1.25rem;" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_usages">Kullanımlar</a>
                        </li>
                    <!--end:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-package="{{$packageSale->id}}"
                               style="font-size: 1.25rem;" data-bs-toggle="tab"
                               href="#kt_ecommerce_customer_policy">Sözleşmeler</a>
                        </li>
                    <!--end:::Tab item-->
                </ul>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">
                @include('business.package-sale.edit.tabs.payments')
                @include('business.package-sale.edit.tabs.usages')
                @include('business.package-sale.edit.tabs.policy')


        </div>


    </div>
</div>
<!--end::Main column-->
