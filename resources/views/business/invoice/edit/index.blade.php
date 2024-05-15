@extends('business.layouts.master')
@section('title', 'Ürün Düzenle')
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
        <a href="{{route('business.invoice.index')}}">Faturalar</a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       Fatura #{{$invoice->payment_id}}
    </li>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        <!-- begin::Invoice 3-->
        <div class="card">
            <div class="card-header">
                <!-- begin::Footer-->
                <div class="card-title">
                    <h3>Fatura Detayı</h3>
                </div>
                    <!-- begin::Actions-->
                    <div class="d-flex align-items-center min-w-300px gap-2 flex-end">
                        <!-- begin::Pint-->
                        <button type="button" class="btn btn-success printBtn" onclick="printInvoice()">
                            Yazdır <i class="fa fa-print ms-2"></i>
                        </button>
                        <!-- end::Pint-->
                       {{--
                         <!-- begin::Download-->
                        <a type="button" class="btn btn-light-success downBtn" href="{{route('business.generateInvoice', $invoice->id)}}">İndir</a>
                        <!-- end::Download-->
                       --}}
                    </div>
                    <!-- end::Actions-->
            </div>
            <!-- begin::Body-->
            <div class="card-body py-20">
                <!-- begin::Wrapper-->
                <div class="mw-lg-950px mx-auto w-100" id="printArea" style="border: 1px solid #e0e0e0;padding: 28px;">
                    <!-- begin::Header-->
                    <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                        <h4 class="fw-bolder text-gray-800 fs-2hx pe-5 pb-7" style="font-size: 26px !important;">{{$business->name}}</h4>
                        <!--end::Logo-->
                        <div class="text-sm-end">
                            <!--begin::Logo-->
                            <a href="#" class="d-block mw-175px ms-sm-auto">
                                <img alt="Logo" src="/front/assets/images/footerLogo.svg" class="w-100" />
                            </a>
                            <!--end::Logo-->
                            <!--begin::Text-->
                            <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                <div>{{$business->address}}</div>
                                <div>{{$business->cities->name. ", ". $business->districts->name}}</div>
                            </div>
                            <!--end::Text-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="pb-12">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column gap-7 gap-md-10">
                            <!--begin::Message-->
                            <div class="fw-bold fs-2">{{authUser()->name}}
                                <span class="fs-6">({{authUser()->email}})</span>
                                <br />
                                <span class="text-muted fs-5">İşte sipariş detaylarınız. Satın alma işleminiz için teşekkür ederiz.</span></div>
                            <!--begin::Message-->
                            <!--begin::Separator-->
                            <div class="separator"></div>
                            <!--begin::Separator-->
                            <!--begin::Order details-->
                            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Sipariş Numarası</span>
                                    <span class="fs-5">#{{$invoice->id}}</span>
                                </div>
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Tarih</span>
                                    <span class="fs-5">{{$invoice->created_at->translatedFormat('d F,Y')}}</span>
                                </div>
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">Fatura Numarası</span>
                                    <span class="fs-5">#{{$invoice->payment_id}}</span>
                                </div>

                            </div>
                            <!--end::Order details-->

                            <!--begin:Order summary-->
                            <div class="d-flex justify-content-between flex-column">
                                <!--begin::Table-->
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <thead>
                                        <tr class="border-bottom fs-6 fw-bold text-muted">
                                            <th class="min-w-175px pb-2">Paket</th>
                                            <th class="min-w-70px text-end pb-2">Paket Kodu</th>
                                            <th class="min-w-80px text-end pb-2">Adet</th>
                                            <th class="min-w-100px text-end pb-2">Toplam</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                        <!--begin::Products-->
                                        <tr>
                                            <!--begin::Product-->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Thumbnail-->
                                                    <a href="#" class="symbol symbol-50px">
                                                        <span class="symbol-label">
                                                            <img src="/business/assets/media/pricing/tag.png" class="mw-40px">
                                                        </span>
                                                    </a>
                                                    <!--end::Thumbnail-->
                                                    <!--begin::Title-->
                                                    <div class="ms-5">
                                                        <div class="fw-bold">Product 1</div>
                                                        <div class="fs-7 text-muted">Hizmet Paketi</div>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <!--end::Product-->
                                            <!--begin::SKU-->
                                            <td class="text-end">{{$invoice->package_id}}</td>
                                            <!--end::SKU-->
                                            <!--begin::Quantity-->
                                            <td class="text-end">1</td>
                                            <!--end::Quantity-->
                                            @php
                                                $taxPrice = ($invoice->package->price * 20) / 100;
                                                $calculatePrice = $invoice->package->price - $taxPrice;
                                            @endphp
                                            <!--begin::Total-->
                                            <td class="text-end">{{formatPrice($calculatePrice)}}</td>
                                            <!--end::Total-->
                                        </tr>

                                        <!--begin::Subtotal-->
                                        <tr>
                                            <td colspan="3" class="text-end">Ara Toplam</td>
                                            <td class="text-end">{{formatPrice($calculatePrice)}}</td>
                                        </tr>
                                        <!--end::Subtotal-->
                                        <!--begin::VAT-->
                                        <tr>
                                            <td colspan="3" class="text-end">KDV (20%)</td>
                                            <td class="text-end">{{formatPrice($taxPrice)}}</td>
                                        </tr>
                                        <!--end::VAT-->

                                        <!--begin::Grand total-->
                                        <tr>
                                            <td colspan="3" class="fs-3 text-dark fw-bold text-end">Genel Toplam</td>
                                            <td class="text-dark fs-3 fw-bolder text-end">{{formatPrice($calculatePrice + $taxPrice)}}</td>
                                        </tr>
                                        <!--end::Grand total-->
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end:Order summary-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Body-->

                </div>
                <!-- end::Wrapper-->
            </div>
            <!-- end::Body-->
        </div>
        <!-- end::Invoice 1-->

    </div>

@endsection
@section('scripts')
    <script>
        var printWindowPayment;
        function printInvoice() {
            // Eğer zaten bir yazdırma penceresi açıksa, işlemi iptal edin
            if (printWindowPayment && !printWindowPayment.closed) {
                console.log("Zaten bir yazdırma penceresi açık. İşlem iptal edildi.");
                return;
            }

            var tableElementPayment = document.getElementById('printArea');
            // Yazdırma penceresini aç
            printWindowPayment = window.open('', '_blank');
            printWindowPayment.document.write('<html><head><title>{{"Fatura:". $invoice->id}}</title>');

            // Orijinal sayfanızda tanımlanan CSS stillerini yazdırma penceresine ekleyin
            var links = document.getElementsByTagName("link");
            for (var i = 0; i < links.length; i++) {
                var link = links[i];
                if (link.rel === "stylesheet") {
                    printWindowPayment.document.write('<link rel="stylesheet" type="text/css" href="' + link.href + '">');
                }
            }
            var now = new Date();
            var formattedDateTime = now.toLocaleString();
            printWindowPayment.document.write('</head><body style="padding-left: 20px">');
            printWindowPayment.document.write(tableElementPayment.outerHTML);
            printWindowPayment.document.write('</body></html>');
            printWindowPayment.document.close();

            // Yeni pencerede yazdırma penceresini aç
            setTimeout(function (){
                printWindowPayment.print();
            }, 1000);

        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
@endsection
