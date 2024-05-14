@extends('business.layouts.master')
@section('title', 'Ödeme Başarılı')
@section('styles')

@endsection
@section('content')
    <!--begin::Pricing card-->
    <div class="card bg-gray-100" id="kt_pricing">
        <!--begin::Card body-->
        <div class="card-body p-lg-17">
            <div class="d-flex justify-content-center">
                <div class="bg-gray-100 text-center w-100" style="max-width: 500px;background: white;border-radius: 28px;padding: 40px;">
                    <img alt="Logo" src="/business/assets/media/email/icon-positive-vote-1.svg" style="max-width: 300px">
                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Ödeme İşleminiz Başarılı!</p>
                        <p style="margin-bottom:2px; color:#7E8299">Seçmiş olduğunuz paket bulunduğunuz</p>
                        <p style="margin-bottom:2px; color:#7E8299">işletme hesabına tanımlandı.</p>
                        <p style="margin-bottom:2px; color:#7E8299">Paketinizdeki hizmetlere erişemiyorsanız</p>
                        <p style="margin-bottom:2px; color:#7E8299"><a class="link-info" href="{{route('business.support-center.index')}}">destek merkezimiz</a> ile iletişime geçiniz</p>

                    </div>
                    <a class="btn btn-primary" href="{{route('business.home')}}">Ödeme Detayını Göster</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
