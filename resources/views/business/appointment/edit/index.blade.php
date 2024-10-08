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
        <a href="{{route('business.appointment.index')}}"> Randevular </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Randevu Detayı
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">

        <!--begin::Order details page-->
        <div class="d-flex flex-column gap-7 gap-lg-10">
            <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">

                <!--end::Button-->
                <div class="d-flex gap-3">

                </div>
            </div>

            <!--begin::Tab content-->
            <div class="row">

                @include('business.appointment.edit.parts.user')

                <div class="col-12">

                    @include('business.appointment.edit.parts.tab-1')
                    @include('business.appointment.edit.parts.tab-2')
                </div>
            </div>
            <!--end::Tab content-->
        </div>
    </div>
    @include('business.appointment.edit.modals.add-service')
    @include('business.appointment.edit.modals.add-sale')
    @include('business.appointment.edit.modals.add-cash-point')
    @include('business.appointment.edit.modals.add-collection')
    @include('business.appointment.edit.modals.add-receivable')

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
