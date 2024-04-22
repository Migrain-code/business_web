@extends('layouts.master')
@section('title', 'Giriş Yap')
@section('style')

@endsection
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('components.login-slider')
            <div class="formBoxForm login-type">
                <div class="mb-4 text-center formLogo">
                    <img src="/front/assets/images/logo-pink.svg" alt="" />
                </div>

                <div class="my-5 text-center">
                    <span class="welcome">Hızlı Randevu’ya hoş geldiniz! </span>
                </div>

                <div class="mb-3">
                    <a href="{{route('personel.login')}}" class="btn-pink w-100 p-4 text-center">
                        Personel Girişi
                    </a>
                </div>
                <div class="mb-0">
                    <a href="{{route('business.login')}}" class="btn-gray blue w-100 p-4 text-center">
                        Patron Girişi
                    </a>
                </div>

                <div class="text-center">
                    <span class="footer-text">Randevularınızı Hızlı ve Kolayca Yönetin!</span>
                </div>
            </div>
        </div>
    </div>
@endsection
