@extends('business.layouts.master')
@section('title', 'Prim Takibi')
@section('styles')
    <style>
        .primCard{
            background: #eaeaea7d;
            padding: 10px;
            line-height: 25px;
            border-radius: 15px;
        }

    </style>
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
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Prim Takibi
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex">
                        <h4>{{"Seçili Personel: ".$personel->name}}</h4>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.case.parts.toolbar')
            </div>
            <!--end::Card header-->

            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <div class="d-flex justify-content-between flex-column flex-md-row">
                                <!--begin::Content-->
                                <div class="flex-grow-1 pt-8 mb-13">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-14">
                                        <table class="table">
                                            <thead>
                                            <tr class="border-bottom fs-6 fw-bold text-muted text-uppercase">
                                                <th class="min-w-175px pb-9">Tür</th>
                                                <th class="min-w-80px pb-9 text-end">Oran</th>
                                                <th class="min-w-80px pb-9 text-end">Ciro</th>
                                                <th class="min-w-100px pe-lg-6 pb-9 text-end">Kazanç</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <x-prim-card
                                                title="Hizmet Cirosu"
                                                icon="danger"
                                                sub-title="{{ $case['appointmentTotal']['rate'] }}"
                                                price-1="{{ $case['appointmentTotal']['appointmentCiro'] }}"
                                                price-2="{{ $case['appointmentTotal']['appointmentRate'] }}">
                                            </x-prim-card>

                                            <x-prim-card
                                                title="Ürün Satışı Cirosu"
                                                icon="success"
                                                sub-title="{{ $case['productSaleTotal']['rate'] }}"
                                                price-1="{{ $case['productSaleTotal']['productSaleCiro'] }}"
                                                price-2="{{ $case['productSaleTotal']['productSaleRate'] }}">
                                            </x-prim-card>
                                            <x-prim-card
                                                title="Paket Satışı Cirosu"
                                                icon="primary"
                                                sub-title="{{ $case['packageSaleTotal']['rate'] }}"
                                                price-1="{{ $case['packageSaleTotal']['packageSaleCiro'] }}"
                                                price-2="{{ $case['packageSaleTotal']['packageSaleRate'] }}">
                                            </x-prim-card>


                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Content-->
                                <div class="d-flex flex-column justify-content-center align-items-center border-left-1 p-3" style="border-left-style: groove;">

                                    <!--begin::Content-->
                                    <div class="text-center pt-5">
                                        <!--begin::Total Amount-->
                                        <div class="fs-3 fw-bold text-muted mb-3">Toplam Ciro</div>
                                        <div class="fs-xl-2x fs-2 fw-bolder">{{formatPrice($case["generalTotal"]["totalCiro"])}}</div>
                                        <div class="text-muted fw-semibold">Hasılat Yapıldı</div>
                                        <!--end::Total Amount-->
                                        <div class="border-bottom w-100 my-5"></div>
                                        <!--begin::Invoice To-->
                                        <!--begin::Total Amount-->
                                        <div class="fs-3 fw-bold text-muted mb-3">Toplam Kazanç</div>
                                        <div class="fs-xl-2x fs-2 fw-bolder">{{formatPrice($case["generalTotal"]["totalRate"])}}</div>
                                        <div class="text-muted fw-semibold">Kazandı</div>

                                    </div>
                                    <!--end::Content-->

                                </div>
                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>

@endsection
@section('scripts')
    <script>
        $(function() {

            function cb(start, end) {
                $('#kt_daterangepicker_4').html(start.format('MMMM D') + ' - ' + end.format('MMMM D'));
            }
            cb(moment().subtract(29, 'days'), moment());

            $('#kt_daterangepicker_4').daterangepicker({
                "timePicker24Hour": true,
                "opens": "left",
                ranges: {
                    'Bugün': [moment(), moment()],
                    'Dün': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Son 7 gün': [moment().subtract(6, 'days'), moment()],
                    'Son 30 Gün': [moment().subtract(29, 'days'), moment()],
                    'Bu ay': [moment().startOf('month'), moment().endOf('month')],
                    'Geçen ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "locale": {
                    "format": "DD.MM.YYYY",
                    "separator": " - ",
                    "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "fromLabel": "Dan",
                    "toLabel": "a",
                    "customRangeLabel": "Özel",
                    "daysOfWeek": [
                        "Pt",
                        "Sl",
                        "Çr",
                        "Pr",
                        "Cm",
                        "Ct",
                        "Pz"
                    ],
                    "monthNames": [
                        "Ocak",
                        "Şubat",
                        "Mart",
                        "Nisan",
                        "Mayıs",
                        "Haziran",
                        "Temmuz",
                        "Ağustos",
                        "Eylül",
                        "Ekim",
                        "Kasım",
                        "Aralık"
                    ],
                    "firstDay": 1
                }
            }, cb);
        });
        $('#personelId').on('change', function (){
            $('#listTypeForm').submit();
            var selectedDate = $('#kt_daterangepicker_4').val();
            if(selectedDate == ""){
                alert('Lütfen Tarih Seçiniz');
            }
        });
    </script>

@endsection
