@extends('business.layouts.master')
@section('title', 'Dashboard')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
       <a href="{{route('business.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content ">

       <div class="row mx-2 mt-0">
           <!--begin::Row-->
           @include('business.dashboard.parts.charts')
       </div>

        <!--end::Row-->
        <div class="row">
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="{{route('business.appointment.index')}}">
                    <div class="widget-stat card ">
                        <div class="card-body rounded p-15" style="background-color: #6a23ff">
                            <h1 class="text-white"><i class="fa fa-calendar-check"
                                                      style="color:white;font-size: 30px"></i>
                                Randevular</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="{{route('business.customer.index')}}">
                    <div class="widget-stat card">
                        <div class="card-body rounded p-15" style="background-color: #9568ff">
                            <h1 class="text-white"><i class="fa fa-user-circle"
                                                      style="color:white;font-size: 30px"></i>
                                Müşteriler</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="{{route('business.personel.index')}}">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-warning p-15">
                            <h1 class="text-white"><i class="fa fa-person"
                                                      style="color:white;font-size: 30px"></i>
                                Personeller</h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="{{route('business.service.index')}}">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-primary p-15">
                            <h1 class="text-white"><i class="fa fa-gear"
                                                      style="color:white;font-size: 30px"></i> Hizmetler
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="{{route('business.product.index')}}">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-black p-15">
                            <h1 class="text-white"><i class="fa fa-box-open"
                                                      style="color:white;font-size: 30px"></i> Ürünler
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-6 mb-2 align-items-center">
                <a href="{{route('business.gallery.index')}}">
                    <div class="widget-stat card">
                        <div class="card-body rounded bg-info p-15">
                            <h1 class="text-white"><i class="fa fa-image"
                                                      style="color:white;font-size: 30px"></i> Galeri
                            </h1>
                        </div>
                    </div>
                </a>
            </div>
        </div>


    </div>
    <!--end::Content-->
@endsection
@section('scripts')
   <script>
       var monthlySaleTotal = @json($monthlySaleTotal);
       var monthlyPackageSaleTotal =@json($monthlyPackageSaleTotal);
       var e = document.getElementById("kt_charts_widget_1_chart_new");
       if (e) {
           var t = {self: null, rendered: !1}, a = function () {
               var a = parseInt(KTUtil.css(e, "height")), o = KTUtil.getCssVariableValue("--bs-gray-500"),
                   r = KTUtil.getCssVariableValue("--bs-gray-200"), s = {
                       series: [
                           {
                               name: "Paket Satışı",
                               data: monthlyPackageSaleTotal
                           },
                           {
                               name: "Ürün Satış",
                               data: monthlySaleTotal
                           }],
                       chart: {fontFamily: "inherit", type: "bar", height: a, toolbar: {show: !1}},
                       plotOptions: {bar: {horizontal: !1, columnWidth: ["30%"], borderRadius: [6]}},
                       legend: {show: !1},
                       dataLabels: {enabled: !1},
                       stroke: {show: !0, width: 2, colors: ["transparent"]},
                       xaxis: {
                           categories: ["Ocak", "Şubat", "Mart", "Nisan", "Mayız", "Haziran", 'Temmuz', 'Ağustos', 'Eylül', "Ekim", "Kasım", "Aralık"],
                           axisBorder: {show: !1},
                           axisTicks: {show: !1},
                           labels: {style: {colors: o, fontSize: "12px"}}
                       },
                       yaxis: {labels: {style: {colors: o, fontSize: "12px"}}},
                       fill: {opacity: 1},
                       states: {
                           normal: {filter: {type: "none", value: 0}},
                           hover: {filter: {type: "none", value: 0}},
                           active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                       },
                       tooltip: {
                           style: {fontSize: "12px"}, y: {
                               formatter: function (e) {
                                   return "₺" + e + " "
                               }
                           }
                       },
                       colors: [KTUtil.getCssVariableValue("--bs-primary"), KTUtil.getCssVariableValue("--bs-gray-300")],
                       grid: {borderColor: r, strokeDashArray: 4, yaxis: {lines: {show: !0}}}
                   };
               t.self = new ApexCharts(e, s), t.self.render(), t.rendered = !0
           };
           a(), KTThemeMode.on("kt.thememode.change", (function () {
               t.rendered && t.self.destroy(), a()
           }))
       }
   </script>
@endsection
