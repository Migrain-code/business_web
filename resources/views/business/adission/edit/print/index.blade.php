<html lang="tr" app="HızlıRandevu" class="ng-scope">
<head>
    <style type="text/css">
        .content-print {
            background: #ffffff;
            font-family: sans-serif;
        }

        .logo-container {
            margin-bottom: 15px;
        }

        .logo {
            margin: 0 auto;
            width: 250px;
        }

        .content-print.a4 {
            width: 600px;
            padding: 0px 10px;
        }

        .content-print.AClass {
            width: 600px;
            padding: 0px 10px;
        }

        .content-print.a5 {
            width: 480px;
            padding: 0px 10px;
        }

        .content-print.termal {
            width: 250px;
            overflow: hidden;
        }

        .content-print.termal>.logo-container>.logo {
            width: 200px;
        }

        .content-print.termal>.logo-container>.logo img {
            width: 200px;
        }

        .content-print>.order-date {
            margin: 13px 0px;
            width: 596px;
            display: block;
            color: #343333;
        }

        .content-print.a4>.order-date {
            font-size: 12px;
        }

        .content-print.AClass>.order-date {
            font-size: 13px;
        }

        .content-print.a5>.order-date {
            font-size: 12px;
            width: 480px;
            margin-top: 0px
        }

        .content-print.termal>.order-table-container {
            border: initial;
            border-top: 1px dashed #000000;
            margin: 5px 0;
            padding: 10px 0;
        }

        .content-print.termal>.order-table-container>span.title {
            display: none;
        }

        .content-print.termal>.order-table-container>.order-table>.header>.quantity,
        .content-print.termal>.order-table-container>.order-table>.row>.quantity {
            width: 34px;
            vertical-align: top;
        }

        .content-print.termal>.order-table-container>.order-table>.header>.food,
        .content-print.termal>.order-table-container>.order-table>.row>.food {
            width: 160px;
            vertical-align: top;
        }

        .content-print.termal>.order-table-container>.order-table>.header>.price,
        .content-print.termal>.order-table-container>.order-table>.row>.price {
            width: 50px;
            vertical-align: top;
        }

        .content-print.termal>.order-table-container>.order-table>.header>.total,
        .content-print.termal>.order-table-container>.order-table>.row>.total {
            width: 85px;
            vertical-align: top;
        }


        .content-print.termal>.order-date {
            font-size: 12px;
            width: 250px;
            border: none;
            margin: 0px;
            padding-bottom: 5px;
            color: #000000;
        }

        .content-print>.order-date>span {
            display: inline-block;
            width: 49%;
            font-weight: bold;
        }

        .align-right {
            text-align: right;
        }

        .content-print.termal>.order-date>span {
            width: 100%;
            display: block;

        }


        .content-print.termal>.order-date>span:first-child {
            border-right: none;
        }

        .content-print.termal>.order-date>span:last-child {
            text-align: left;
        }

        .content-print>.delivery-address {
            border: 1px dashed #343333;
            color: #343333;
            display: block;
            margin: 0;
            padding: 10px;
            word-wrap: break-word;
        }

        .content-print.a4>.delivery-address {
            font-size: 13px;
            margin: 20px 0;
        }

        .content-print.AClass>.delivery-address {
            font-size: 13px;
        }

        .content-print.a5>.delivery-address {
            font-size: 11px;
            margin: 20px 0;
        }

        .content-print.termal>.delivery-address {
            width: 250px;
            border: none;
            border-top: dashed 1px #000000;
            padding: 0px;
            margin: 0px;
            padding-top: 5px;
            font-size: 13px;
            color: #000000;
        }

        .content-print>.delivery-address>.title {
            background: #ffffff;
            font-weight: bold;
            padding: 0px 3px;
            margin-top: -19px;
            position: absolute;
        }

        .content-print.a4>.delivery-address>.title {
            font-size: 12px;
        }

        .content-print.AClass>.delivery-address>.title {
            font-size: 13px;
        }

        .content-print.a5>.delivery-address>.title {
            font-size: 12px;
        }

        .content-print.termal>.delivery-address>.title {
            display: none;
        }

        .content-print>.delivery-address>.customer-name,
        .content-print>.delivery-address>.address,
        .content-print>.delivery-address>.address-description,
        .content-print>.delivery-address>.phone {
            display: block;
        }

        .content-print.termal>.delivery-address>.address {
            margin-top: 10px;
        }

        .content-print>.delivery-address>.address-description {
            margin-top: 16px;
        }

        .content-print.a5>.delivery-address>.address-description {
            margin-top: 5px;
        }

        .content-print.termal>.delivery-address>.address-description {
            margin: 3px 0 3px;
        }

        .content-print>.promotion {
            margin-top: 16px;
        }

        .content-print.a4>.promotion {
            font-size: 11px;
        }

        .content-print.AClass>.promotion {
            font-size: 11px;
        }

        .content-print.a5>.promotion {
            font-size: 9px;
            margin-top: 5px;
        }

        .content-print.termal>.promotion {
            font-size: 11px;
            margin-top: 5px;
        }

        .content-print>.delivery-date {
            font-weight: bold;
            width: 586px;
            margin: 10px 0px;
        }

        .content-print.a4>.delivery-date {
            font-size: 14px;
        }

        .content-print.AClass>.delivery-date {
            font-size: 14px;
        }

        .content-print.a5>.delivery-date {
            font-size: 12px;
            width: 466px;
            margin: 5px 0px;
        }

        .content-print.termal>.delivery-date {
            font-size: 12px;
            width: 250px;
            border: none;
            border-top: dashed 1px #343333;
            border-bottom: dashed 1px #000000;
            padding: 5px 0px;
        }

        .content-print>.restaurant {
            border: dashed 2px #343333;
            border-bottom: none;
            font-weight: bold;
            width: 586px;
            min-height: 16px;
            padding-left: 10px;
        }

        .content-print.a4>.restaurant {
            font-size: 13px;
        }

        .content-print.AClass>.restaurant {
            font-size: 13px;
        }

        .content-print.a5>.restaurant {
            font-size: 11px;
            width: 466px;
            min-height: 8px;
        }

        .content-print.termal>.restaurant {
            font-size: 12px;
            font-weight: normal;
            width: 250px;
            min-height: 10px;
            border: none;
            padding-left: 2px;
        }

        .content-print>.order-table-container {
            border: 1px dashed #343333;
            color: #000000;
            display: block;
            margin: 0;
            padding: 10px;
            word-wrap: break-word;
        }

        .content-print>.order-table-container span.title {
            background: #ffffff;
            font-weight: bold;
            padding: 0px 3px;
            margin-top: -19px;
            position: absolute;
            font-size: 12px;
        }

        .content-print>.order-table-container>.order-table {
            display: table;
        }

        .content-print.a5>.order-table-container>.order-table {
            margin-top: 5px;
        }

        .content-print.termal>.order-table {
            width: 250px;
            border: none;
        }

        .content-print>.order-table-container>.order-table>.header {
            font-weight: bold;
            width: 100%;
            border-bottom: none;
        }

        .content-print>.order-table-container>.order-table>.row {
            font-size: 12px;
        }

        .content-print.a4>.order-table-container>.order-table>.header {
            font-size: 12px;
        }

        .content-print.AClass>.order-table>.header {
            font-size: 12px;
        }

        .content-print.a5>.order-table-container>.order-table>.header,
        .content-print.termal>.order-table-container>.order-table>.header {
            font-size: 12px;
        }

        .content-print.termal>.order-table>.header {
            border: none;
            background: none;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .content-print>.order-table>.row {
            float: left;
            display: table-row;
        }

        .content-print.a4>.order-table>.row {
            font-size: 12px;
        }

        .content-print.AClass>.order-table>.row {
            font-size: 12px;
        }

        .content-print.a5>.order-table>.row,
        .content-print.termal>.order-table>.row {
            font-size: 12px;
        }

        .content-print>.order-table>.header>div,
        .content-print>.order-table>.row>div {
            display: table-cell;
        }


        .content-print.termal>.order-table>.row>div {
            border-top: none;
        }

        .content-print>.order-table-container>.order-table>.header>.quantity,
        .content-print>.order-table-container>.order-table>.row>.quantity,
        .content-print>.order-table-container>.order-table>.header>.food,
        .content-print>.order-table-container>.order-table>.row>.food,
        .content-print>.order-table-container>.order-table>.header>.price,
        .content-print>.order-table-container>.order-table>.row>.price {
            text-align: left;
        }

        .content-print>.order-table-container>.order-table>.header>.quantity,
        .content-print>.order-table-container>.order-table>.row>.quantity {
            width: 70px;
            display: inline-block;
        }

        .content-print>.order-table-container>.order-table>.header>.food,
        .content-print>.order-table-container>.order-table>.row>.food {
            width: 319px;
            display: inline-block;
        }

        .content-print>.order-table-container>.order-table>.header>.price,
        .content-print>.order-table-container>.order-table>.row>.price {
            width: 60px;
            display: inline-block;
        }

        .content-print>.order-table-container>.order-table>.header>.total,
        .content-print>.order-table-container>.order-table>.row>.total {
            width: 65px;
            text-align: right;
            display: inline-block;
        }

        .content-print.a5>.order-table-container>.order-table>.header>.quantity,
        .content-print.a5>.order-table-container>.order-table>.row>.quantity {
            width: 60px;
        }

        .content-print.a5>.order-table-container>.order-table>.header>.food,
        .content-print.a5>.order-table-container>.order-table>.row>.food {
            width: 259px;
        }

        .content-print.a5>.order-table-container>.order-table>.header>.price,
        .content-print.a5>.order-table-container>.order-table>.row>.price {
            width: 60px;
        }

        .content-print.a5>.order-table>.header>.total,
        .content-print.a5>.order-table>.row>.total {
            width: 60px;
        }

        .content-print.termal>.order-table>.header>.quantity,
        .content-print.termal>.order-table>.row>.quantity {
            width: 30px;
            border-right: none;
        }

        .content-print.termal>.order-table>.header>.food,
        .content-print.termal>.order-table>.row>.food {
            width: 145px;
            border-right: none;
            text-align: left;
        }

        .content-print.termal>.order-table>.header>.price,
        .content-print.termal>.order-table>.row>.price {
            width: 35px;
            border-right: none;
            text-align: left;
        }

        .content-print.termal>.order-table>.header>.total,
        .content-print.termal>.order-table>.row>.total {
            width: 35px;
        }

        .content-print>.information {
            float: left;
            margin-top: 20px;
            max-width: 100%;
        }

        .content-print.a5>.information {
            margin: 10px 0;
        }

        .content-print.termal>.information {
            width: 250px;
            border: none;
            border-top: dashed 1px #000000;
            margin-top: 5px;
        }

        .content-print>.information>.tracking-number {
            float: left;
            width: 391px;
            text-align: center;
            font-weight: bold;
            padding: 5px 0px;
        }

        .content-print.a4>.information>.tracking-number {
            font-size: 44px;
        }

        .content-print.AClass>.information>.tracking-number {
            font-size: 44px;
        }

        .content-print.a5>.information>.tracking-number {
            font-size: 34px;
            width: 321px;
            padding: 2px 0px;
        }

        .content-print.termal>.information>.tracking-number {
            font-size: 28px;
            width: 250px;
            padding: 2px 0px;
        }

        .content-print>.information>.customer-note {
            float: left;
            word-wrap: break-word;
            max-width: 100%;
            width: 100%;
        }

        .content-print.a4>.information>.customer-note {
            font-size: 13px;
        }

        .content-print.AClass>.information>.customer-note {
            font-size: 13px;
        }

        .content-print.a5>.information>.customer-note {
            font-size: 12px;
        }

        .content-print.termal>.information>.customer-note {
            font-size: 12px;
            width: 240px;
            padding-top: 5px;
        }

        .content-print>.information>.customer-note>span {
            font-weight: bold;
            display: inline-block;
        }

        .content-print>.information>.payment-note {
            text-align: left;
            float: left;
            padding: 5px 0 0 0;
            font-size: 12px;
        }

        .content-print.a4>.information>.payment-note {
            font-size: 13px;
        }

        .content-print.AClass>.information>.payment-note {
            font-size: 13px;
        }


        .content-print.termal>.information>.payment-note {
            font-size: 12px;
        }

        .content-print>.order-table-container>.payment-total {
            text-align: right;
            margin: 10px 0 0 0;
            font-size: 12px;
        }

        .content-print>.order-table-container>.payment-total .item {
            width: 80px;
            display: inline-block
        }

        .content-print.a4>.payment-total {
            font-size: 13px;
        }

        .content-print.AClass>.payment-total {
            font-size: 13px;
        }

        .content-print.a5>.order-table-container>.payment-total {
            font-size: 12px;
        }

        .content-print.termal>.payment-total {
            font-size: 11px;
            width: 250px;
            margin: 0px 0px 0px 0px;
        }

        .content-print>.payment-total>.subtotal,
        .content-print>.payment-total>.shipping,
        .content-print>.payment-total>.tax,
        .content-print>.payment-total>.total {
            float: right;
            width: 100%;
        }

        .content-print>.payment-total>.subtotal>span,
        .content-print>.payment-total>.shipping>span,
        .content-print>.payment-total>.tax>span,
        .content-print>.payment-total>.total>span {
            font-weight: bold;
            float: left;
        }

        .content-print>.payment-total>.total {
            font-weight: bold;
        }

        .content-print.termal>.payment-total>.tax {
            display: none;
        }

        .content-print.termal>.payment-total>.total {
            font-size: 14px;
            font-weight: normal;
        }

        .content-print>.footer-bar {
            float: left;
            border-top: dashed 1px #343333;
            width: 590px;
            margin-top: 10px;
            text-align: center;
        }

        .content-print.a4>.footer-bar {
            font-size: 13px;
            padding-top: 5px;
        }

        .content-print.AClass>.footer-bar {
            font-size: 13px;
        }

        .content-print.a5>.footer-bar {
            font-size: 11px;
            width: 480px;
            margin-top: 5px;
            padding-top: 5px;
        }

        .content-print.termal>.footer-bar {
            font-size: 11px;
            width: 250px;
            margin-top: 5px;
            padding-right: 0px;
            text-align: center;
            border-top-color: #000000;
            padding-top: 5px;
        }

        .content-print.termal>.logo {
            width: 200px;
        }

        .bold {
            font-weight: bold;
        }

        @page {
            margin: 2mm;
        }

        @media print {
            body {
                background: #FFFFFF;
            }

            #header,
            #site>.footer,
            #site>.placeholder {
                display: none;
            }

            #site>.content {
                width: 100%;
                margin: 0px;
            }
        }

        [ng\:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak {
            display: none !important;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Print Page</title>
</head>
<body style="zoom: 1;">

<div id="site" ng-view="" class="ng-scope">
    <div class="content-print  termal">

        <div class="order-date">
            <span class="ng-binding" style="text-align: center;font-size: 15px;margin-bottom: 15px;">
                {{$adission->business->name}}
            </span>

            <span class="align-right ng-binding">Rand. Zamanı: {{$adission->start_time->format('d.m.Y H:i')}}</span>
        </div>
        <div class="delivery-address">
            <span class="title ng-binding">Gönderim Adresi</span>
            <span class="customer-name ng-binding">{{$adission->customer->name}}</span>

        </div>
        <div class="order-table-container">
            <span class="title">Sipariş Detayı</span>
            <div class="order-table">
                <div class="header">
                    <div class="food ng-binding">Hizmet</div>
                    <div class="total ng-binding">Tutar</div>
                </div>
                @foreach($adission->services as $service)
                    <div class="row ng-scope" style="margin-top: 5px">
                        <div class="food ng-binding">{{$service->service->subCategory->getName()}} </div>
                        <div class="total ng-binding">{{formatPrice($service->service->price)}}</div>
                    </div>
                @endforeach


            </div>
            <div class="payment-total">
                <div class="total ng-binding">
						<span class="bold item ng-binding">
							Ara Toplam:
						</span>  {{formatPrice($adission->calculateTotal())}}
                </div>
                <div class="total ng-binding">
						<span class="bold item ng-binding" style="margin-right: 14px;">
							İndirim :
						</span>  {{formatPrice($adission->calculateCampaignDiscount())}}
                </div>
                <div class="total ng-binding">
						<span class="bold item ng-binding">
							Toplam:
						</span>

                    {{formatPrice($adission->calculateTotal()-$adission->calculateCampaignDiscount())}}
                </div>
            </div>
        </div>
        <div class="promotion ng-binding"></div>

        <div class="information">
            <div class="customer-note ng-binding"><span class="ng-binding">Adisyon No: #{{$adission->id}}</span>
            </div>
            @if($adission->payments->count() == 1)
                <div class="payment-note ng-binding"><span class="bold">Ödeme Şekli:</span> {{$adission->payments->first()->type("name")}}</div>
            @endif
        </div>

        <div class="footer-bar">
            <div class="logo-container" style="">
                <div class="logo">
                    <img src="/front/assets/images/logo-dark.svg" class="ng-scope" style="width: 160px; margin-top: 5px">
                </div>
            </div>

        </div>

    </div>
</div>
<script type="text/javascript">
    window.print();
    window.onafterprint = function () {
        window.close();
    }
</script>
</body>
</html>
