@extends('business.layouts.master')
@section('title', 'Kasa')
@section('styles')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .summary {
            font-weight: bold;
            text-align: right;
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
        Kasa
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-1 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <h1>Kasa Raporu</h1>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                @include('business.case.parts.toolbar')
            </div>
            <!--end::Card header-->

            <div class="row mx-5">
                <div class="container mt-5">
                    <h3>Kalan Tutar</h3>
                    <table class="table-responsive">
                        <thead>
                        <tr>
                            <th>Ödeme Yöntemi</th>
                            <th>Tutar (TL)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Nakit</td>
                            <td>{{formatPrice($totals["cashTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Kredi Kartı</td>
                            <td>{{formatPrice($totals["creditTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Havale</td>
                            <td>{{formatPrice($totals["eftTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Diğer</td>
                            <td>{{formatPrice($totals["otherTotal"])}}</td>
                        </tr>
                        <tr class="total-row">
                            <td>Toplam</td>
                            <td>{{formatPrice($totals["total"])}}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h3>Gelirler</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Ödeme Yöntemi</th>
                            <th>Tutar (TL)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Nakit</td>
                            <td>{{formatPrice($closingBalance["cashTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Kredi Kartı</td>
                            <td>{{formatPrice($closingBalance["creditTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Havale</td>
                            <td>{{formatPrice($closingBalance["eftTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Diğer</td>
                            <td>{{formatPrice($closingBalance["otherTotal"])}}</td>
                        </tr>
                        <tr class="total-row">
                            <td>Toplam Gelir</td>
                            <td>{{formatPrice($closingBalance["total"])}}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h3>Masraflar</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>Ödeme Yöntemi</th>
                            <th>Tutar (TL)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Nakit</td>
                            <td>{{formatPrice($totalExpense["cashTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Kredi Kartı</td>
                            <td>{{formatPrice($totalExpense["creditTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Havale</td>
                            <td>{{formatPrice($totalExpense["eftTotal"])}}</td>
                        </tr>
                        <tr>
                            <td>Diğer</td>
                            <td>{{formatPrice($totalExpense["otherTotal"])}}</td>
                        </tr>
                        <tr class="total-row">
                            <td>Toplam Masraf</td>
                            <td>{{formatPrice($totalExpense["total"])}}</td>
                        </tr>
                        </tbody>
                    </table>

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
                    'Son 30 gün': [moment().subtract(29, 'days'), moment()],
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
            }, cb).on('apply.daterangepicker', function(ev, picker) {
                // Formu gönder
                $('#listTypeForm').submit();
            });
        });

    </script>
@endsection
