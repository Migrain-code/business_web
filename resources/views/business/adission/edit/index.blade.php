@extends('business.layouts.master')
@section('title', 'Adisyon Detayı')
@section('styles')
    <style>
        .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank.svg');
        }

        [data-bs-theme="dark"] .image-input .image-input-wrapper {
            background-image: url('/business/assets/media/svg/avatars/blank-dark.svg');
        }
    </style>
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Dashboard </a>
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
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                           href="#kt_ecommerce_sales_order_history">Satışlar</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" onclick="fethPaymentInfo()" data-bs-toggle="tab"
                           href="#kt_ecommerce_adission_payment">Ödeme</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" onclick="" data-bs-toggle="tab"
                           href="#kt_ecommerce_adission_collection">Tahsilatlar</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" onclick="" data-bs-toggle="tab"
                           href="#kt_ecommerce_adission_receivables">Alacaklar</a>
                    </li>
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->

                <!--begin::Button-->
                <a href="{{route('business.adission.index')}}"
                   class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                    <i class="ki-duotone ki-left fs-2"></i> </a>
                <!--end::Button-->
                <div class="d-flex gap-3">
                    <!--begin::Button-->
                    <button data-bs-toggle="modal" onclick="fetchProductCreateInfos()"
                            data-bs-target="#adission_add_product_sale_modal" class="btn btn-light-warning btn-sm">Ürün
                        Satışı Ekle
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button data-bs-toggle="modal" data-bs-target="#kt_modal_add_service"
                            class="btn btn-light-primary btn-sm">Hizmet Ekle
                    </button>
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
            <!--begin::Order summary-->
            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                <!--begin::Order details-->
                <div class="card card-flush py-4 flex-row-fluid">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center">
                        <div class="card-title">
                            <h2>Adisyon Detayı (#{{$appointment->id}})</h2>
                        </div>
                        <div class="btn-wrapper">
                            <button type="button" class="btn btn-lg btn-icon btn-icon-primary btn-light-primary me-n3"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                <span class="svg-icon svg-icon-3 svg-icon-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                         viewBox="0 0 24 24">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="5" y="5" width="5" height="5" rx="1" fill="currentColor"></rect>
                                            <rect x="14" y="5" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                            <rect x="5" y="14" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                            <rect x="14" y="14" width="5" height="5" rx="1" fill="currentColor"
                                                  opacity="0.3"></rect>
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </button>
                            <div
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                data-kt-menu="true" style="">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">İşlemler</div>
                                </div>
                                <!--end::Heading-->

                                    <form method="post"
                                          action="{{route('business.adission.update', $appointment->id)}}"
                                          id="approveForm">
                                        @csrf
                                        @method('PUT')
                                    </form>
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" onclick="$('#approveForm').submit()"
                                           class="menu-link px-3 flex-stack">Geldi
                                            <i class="fas fa-check-circle ms-2 fs-7">
                                            </i>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                <!--begin::Menu item-->

                                    <form method="post"
                                          action="{{route('business.adission.destroy', $appointment->id)}}"
                                          id="cancelForm">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" onclick="$('#cancelForm').submit()"
                                           class="menu-link flex-stack px-3">İptal Et
                                            <i class="fas fa-exclamation-circle ms-2 fs-7"
                                               data-bs-toggle="tooltip"
                                               title="Specify a target name for future usage and reference"
                                               data-kt-initialized="1">

                                            </i>
                                        </a>
                                    </div>

                                <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">

                                        <a href="{{route('business.adission.edit', $appointment->id)}}"
                                           class="menu-link flex-stack px-3">Gelmedi
                                            <i class="fas fa-user-slash ms-2 fs-7">
                                            </i>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">

                                    <a href="{{route('business.adission.paymentClose', $appointment->id)}}"
                                       class="menu-link flex-stack px-3">Tahsilatsız Kapat
                                        <i class="fas fa-money-bill-1 ms-2 fs-7">
                                        </i>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                            </div>
                        </div>

                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-calendar-8 fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            Randevu Tarihi
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{\Illuminate\Support\Carbon::parse($appointment->start_time)->format('d.m.Y H:i:s')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-electronic-clock fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            İşlem Süresi
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{\Illuminate\Support\Carbon::parse($appointment->end_time)->diffInMinutes($appointment->start_time)}}
                                        .DK
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-calendar fs-2 me-2"><span class="path1"></span><span
                                                    class="path2"></span></i> Durumu
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{!! $appointment->status("html") !!}</td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Order details-->

                <!--begin::Customer details-->
                <div class="card card-flush py-4  flex-row-fluid">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Müşteri Detayı</h2>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-profile-circle fs-2 me-2"><span
                                                    class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></i> Müşteri Adı
                                        </div>
                                    </td>

                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                <a href="{{route('business.customer.edit', $appointment->customer_id)}}">
                                                    <div class="symbol-label">
                                                        <img src="{{image($appointment->customer->image)}}"
                                                             alt="{{$appointment->customer->name}}" class="w-100">
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->

                                            <!--begin::Name-->
                                            <a href="{{route('business.customer.edit', $appointment->customer_id)}}"
                                               class="text-gray-600 text-hover-primary">
                                                {{$appointment->customer->name}}
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-sms fs-2 me-2"><span class="path1"></span><span
                                                    class="path2"></span></i> E-posta
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <a href="{{route('business.customer.edit', $appointment->customer->id)}}"
                                           class="text-gray-600 text-hover-primary">
                                            {{$appointment->customer->email}} </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-phone fs-2 me-2"><span class="path1"></span><span
                                                    class="path2"></span></i> Telefon
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        @php
                                            $formattedPhone = formatPhone($appointment->customer->phone);
                                        @endphp
                                        <a href="tel: {{$formattedPhone}}">{{$formattedPhone}}</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Customer details-->
                <!--begin::Documents-->
                <div class="card card-flush py-4  flex-row-fluid">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Diğer</h2>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-devices fs-2 me-2">
                                                <span class="path1"></span>
                                                <span
                                                    class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span></i>
                                            Kupon Kullanımı
                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                  title="Müşteri Bir Kupon Kodu Kullanmışsa Kullandığı kodu bu alanda görüntülenir">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        @if(isset($appointment->campaign_id))
                                            <a href="">{{$appointment->campaign->getTitle()}}</a>
                                        @else
                                            Yok
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-note fs-2 me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            Not
                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                  title="Bu adisyona bırakılan notlar">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{$appointment->note}}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Documents-->
            </div>
            <!--end::Order summary-->

            <!--begin::Tab content-->
            <div class="tab-content">
                @include('business.adission.edit.parts.tab-1')
                @include('business.adission.edit.parts.tab-2')
                @include('business.adission.edit.parts.tab-3')
                @include('business.adission.edit.parts.tab-4')
                @include('business.adission.edit.parts.tab-5')


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
            {data: 'id'},
            {data: 'created_at'},
            {data: 'customerName'},
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
