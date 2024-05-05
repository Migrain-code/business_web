@extends('layouts.master')
@section('title', 'Giriş Yap')
@section('style')
    <style>
        .formBox .formBoxContent .formBoxForm .registerLabel {
            text-align: center;
            display: block;
            margin-bottom: 16px;
            font-style: normal;
            font-weight: 400;
            font-size: 15px;
            line-height: 0px;
            color: #43506e;
        }
    </style>
@endsection
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('components.login-slider')
            <div class="formBoxForm login-type">
                <div class="" style="margin-bottom: 87px !important;">
                    <label class="registerLabel">
                        <h3>Oturum Açma Ekranı</h3>
                    </label>
                    <label class="registerLabel">Zamanı Yönet, Randevularla Zirveye Ulaş!</label>
                </div>
                <div class="mb-2">
                    <a href="{{route('business.login')}}" class="btn-gray blue w-100 p-4 text-center">
                        Patron Girişi
                    </a>
                </div>
                <div class="mb-2 d-flex justify-content-center" >
                    <img src="/front/assets/images/login/arrows.png" style="width: 30px;transform: rotate(270deg);">
                </div>
                <div class="mb-3">
                    <a href="{{route('personel.login')}}" class="btn-pink w-100 p-4 text-center">
                        Personel Girişi
                    </a>
                </div>

                <div class="text-center pb-3">
                     <div class="footer-text">
                        <label class="registerLabel">Üyeliğiniz Yok Mu?</label>
                        <a href="{{route('business.register')}}" class="btn-gray w-100 p-4 text-center">Ücretsiz Kayıt Ol</a>
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection
