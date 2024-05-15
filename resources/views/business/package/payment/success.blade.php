@extends('business.layouts.master')
@section('title', 'Ödeme Başarılı')
@section('styles')

@endsection
@section('content')
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color: rgb(213, 217, 226); --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc; height: 242px;">
        <!--begin::Email template-->
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                    <tr>
                        <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                            <!--begin:Email content-->
                            <div style="text-align:center; margin:0 60px 34px 60px">
                                <!--begin:Logo-->
                                <!--begin:Media-->
                                <div style="margin-bottom: 15px">
                                    <img alt="Logo" src="/business/assets/media/email/icon-positive-vote-3.svg">
                                </div>
                                <!--end:Media-->
                                <!--begin:Text-->
                                <div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Arial,Helvetica,sans-serif">
                                    <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">{{$order->package->name}} Paket Sisteminize Tanımlandı!</p>
                                    <p style="margin-bottom:2px; color:#7E8299">Paketin özellikleri ile ilgili detaylara</p>
                                    <p style="margin-bottom:2px; color:#7E8299">abonelik menüsünden ya da fiyatlandırma</p>
                                    <p style="margin-bottom:2px; color:#7E8299">sayfamızdan öğrenebilirsiniz</p>
                                </div>
                                <!--end:Text-->
                                <!--begin:Order-->
                                <div style="margin-bottom: 15px">
                                    <!--begin:Title-->
                                    <h3 style="text-align:left; color:#181C32; font-size: 18px; font-weight:600; margin-bottom: 22px">Sipariş özeti</h3>
                                    <!--end:Title-->
                                    @php
                                        $taxPrice = ($order->package->price * 20) / 100;
                                        $calculatePrice = $order->package->price - $taxPrice;
                                    @endphp
                                    <!--begin:Items-->
                                    <div style="padding-bottom:9px">
                                        <!--begin:Item-->
                                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500; margin-bottom:8px">
                                            <!--begin:Description-->
                                            <div style="font-family:Arial,Helvetica,sans-serif">İşletme - {{$order->package->type == 0 ? "Aylık": "Yıllık"}} fatura</div>
                                            <!--end:Description-->
                                            <!--begin:Total-->
                                            <div style="font-family:Arial,Helvetica,sans-serif">{{formatPrice($calculatePrice)}}</div>
                                            <!--end:Total-->
                                        </div>
                                        <!--end:Item-->
                                        <!--begin:Item-->
                                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500;">
                                            <!--begin:Description-->
                                            <div style="font-family:Arial,Helvetica,sans-serif">KDV (20%)</div>
                                            <!--end:Description-->
                                            <!--begin:Total-->
                                            <div style="font-family:Arial,Helvetica,sans-serif">{{formatPrice($taxPrice)}}</div>
                                            <!--end:Total-->
                                        </div>
                                        <!--end:Item-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed" style="margin:15px 0"></div>
                                        <!--end::Separator-->
                                        <!--begin:Item-->
                                        <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 14px; font-weight:500">
                                            <!--begin:Description-->
                                            <div style="font-family:Arial,Helvetica,sans-serif">Toplam ödeme</div>
                                            <!--end:Description-->
                                            <!--begin:Total-->
                                            <div style="color:#50cd89; font-weight:700; font-family:Arial,Helvetica,sans-serif">{{formatPrice($calculatePrice + $taxPrice)}}</div>
                                            <!--end:Total-->
                                        </div>
                                        <!--end:Item-->
                                    </div>
                                    <!--end:Items-->
                                </div>
                                <!--end:Order-->
                                <!--begin:Action-->
                                <a href="{{route('business.invoice.index')}}" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">
                                    Faturalarıma Git
                                </a>
                                <!--begin:Action-->
                            </div>
                            <!--end:Email content-->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                            <p style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">Faturanız ile ilgili bir sorun mu oluştu!</p>
                            <p style="margin-bottom:2px">Destek merkezinden fatura numaranız </p>
                            <p style="margin-bottom:4px">ile birlikte bize ulaşabilirsiniz
                                <a href="{{route('business.support-center.index')}}" rel="noopener" target="_blank" style="font-weight: 600">Destek Merkezi</a>.</p>
                            <p>Pzt-Cuma, 09:00-18:00 saatleri arasında hizmet vermekteyiz.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Email template-->
    </div>
@endsection

@section('scripts')

@endsection
