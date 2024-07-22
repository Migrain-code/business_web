@extends('business.layouts.master')
@section('title', 'Adisyon Detayı')
@section('styles')

@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.adission.index')}}"> Adisyonlar </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Adisyon Detayı
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">

        <!--begin::Order details page-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
            <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                           href="#kt_ecommerce_sales_order_summary">Adisyon Bilgileri</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->
                <!--begin::Button-->

                <!--end::Button-->
                <div class="d-flex gap-3">
                    <!--begin::Button-->
                    {{--
                     <a href="{{route('business.adission.index')}}"
                   class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                    <i class="ki-duotone ki-left fs-2"></i> </a>
                         <button data-bs-toggle="modal" onclick="fetchProductCreateInfos()"
                            data-bs-target="#adission_add_product_sale_modal" class="btn btn-light-warning btn-sm">Ürün
                        Satışı Ekle
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button data-bs-toggle="modal" data-bs-target="#kt_modal_add_service"
                            class="btn btn-light-primary btn-sm">Hizmet Ekle
                    </button>
                     --}}
                    <!--end::Button-->
                    {{--
                        <button type="button" data-bs-toggle="modal" onclick="createCollection()"
                            data-bs-target="#kt_modal_add_payment" style="padding: 10px 20px !important;" class="btn btn-light-info me-2  btn-sm">
                        <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                        Tahsilat Ekle
                    </button>
                    --}}
                </div>
            </div>

            <!--begin::Tab content-->
            <div class="row">

                @include('business.adission.edit.parts.user')

                <div class="col-7">
                    @include('business.adission.edit.parts.tab-1')
                    @include('business.adission.edit.parts.tab-2')
                </div>
                <div class="col-5">
                    @include('business.adission.edit.parts.tab-4')
                </div>



            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Order details page-->
    </div>
    @include('business.adission.edit.modals.add-service')
    @include('business.adission.edit.modals.add-sale')
    @include('business.adission.edit.modals.add-cash-point')
    @include('business.adission.edit.modals.add-collection')
    @include('business.adission.edit.modals.add-receivable')

@endsection
@section('scripts')
    {{-- Ürün Satış Listesi --}}
    <script src="/business/assets/js/project/adission/edit/sale/listing.js"></script>
    <script>
        let DATA_URL = "{{route('business.adission.sale.datatable', $appointment->id)}}";
        let DATA_COLUMNS = [
            {data: 'created_at'},
            {data: 'productName'},
            {data: 'personelName'},
            {data: 'piece'},
            {data: 'total'},
            {data: 'action'}
        ];
    </script>
    <script>
        function fetchProductCreateInfos() {
            var productSelect = $('#product_select');
            var productPersonelSelect = $('#product_personel_select');
            var paymentTypeSelect = $('#payment_type_select');
            productSelect.empty();
            productPersonelSelect.empty();
            paymentTypeSelect.empty();
            $.ajax({
                url: '/isletme/adission/' + {{$appointment->id}} + '/sale/create',
                type: "GET",
                dataType: "JSON",
                success: function (res) {
                    productSelect.append('<option value="">Ürün Seçiniz</option>');
                    $.each(res.products, function (index, item) {
                        productSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                    productPersonelSelect.append('<option value="">Personel Seçiniz</option>');
                    $.each(res.personels, function (index, item) {
                        productPersonelSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                    paymentTypeSelect.append('<option value="">Ödeme Yöntemi Seçiniz</option>');
                    $.each(res.paymentTypes, function (index, item) {
                        paymentTypeSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
        }

        function fethPaymentInfo() {
            $.ajax({
                url: '/isletme/adission/' + {{$appointment->id}} + '/payment',
                type: "GET",
                dataType: "JSON",
                success: function (res) {
                    console.log(res);
                    document.getElementById('totalPayment').innerText = res.total;
                    document.getElementById('cashpoint').innerText = res.cashPoint;
                    document.getElementById('campaignDiscount').innerText = res.campaignDiscount;
                    document.getElementById('remainingAmount').innerText = res.remaining_amount;
                    document.getElementById('collectedTotal').innerText = res.collectedTotal;
                }
            });
        }

        function fetchCashPointInfos() {
            var cashPointSelect = $('#cashPoint_select');
            $.ajax({
                url: '/isletme/adission/' + {{$appointment->id}} + '/cash-point',
                type: "GET",
                dataType: "JSON",
                success: function (res) {
                    cashPointSelect.append('<option value="">Parapuan Seçiniz</option>');

                    $.each(res, function (index, item) {
                        cashPointSelect.append('<option value="' + item.id + '">' + item.price + "₺" + '</option>');
                    });
                }
            });
        }

        function createCollection() {
            var paymentTypeSelector = $('#kt_ecommerce_payment_type_select');

            paymentTypeSelector.empty();

            $.ajax({
                url: '/isletme/adission/' + {{$appointment->id}} + '/sale/create',
                type: "GET",
                dataType: "JSON",
                success: function (res) {
                    paymentTypeSelector.append('<option value="">Ödeme Yöntemi Seçiniz</option>');
                    $.each(res.paymentTypes, function (index, item) {
                        paymentTypeSelector.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            });
        }
    </script>
    <script>
        var adissionId = '{{$appointment->id}}';
    </script>

    <script src="/business/assets/js/project/adission/edit/payments/add-payment.js"></script>
    <script src="/business/assets/js/project/adission/edit/payments/fetchPaymentList.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <script src="/business/assets/js/project/adission/edit/receivable/add-receivable.js"></script>
    <script src="/business/assets/js/project/adission/edit/receivable/fetchReceivableList.js"></script>

    <script>
        $('.addCashPoint').on('click', function () {
            Swal.fire({
                title: 'Parapuanı eklemek istediğine eminmisin',
                text: 'Evete tıkladığında parapuan müşteriye yüklenecek ve bu işlem geri alınamayacaktır.',
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Evet, Yükle!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/isletme/adission/'+adissionId+'/payment/save',
                        type: "POST",
                        data: {
                            "_token": csrf_token,
                            'isPoint': 1,
                        },
                        dataType: "JSON",
                        success: function (res) {
                            Swal.fire({
                                title: res.message,
                                icon: res.status,
                            })
                        }
                    });
                }
            });

        })

    </script>
@endsection
