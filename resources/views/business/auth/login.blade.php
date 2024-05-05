@extends('layouts.master')
@section('title', 'Yetkili Girişi')
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('components.login-slider')
            <div class="formBoxForm">
                <div class="mb-0 mt-2">
                    <label class="registerLabel">
                        <h3>İşletme Girişi</h3>
                    </label>
                    <label class="registerLabel">30 gün ücretsiz deneme sürenizi başlatın</label>
                </div>
                <form id="loginForm" method="post" action="{{route('business.login')}}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input
                            type="text"
                            class="form-control"
                            id="validatorPhone"
                            placeholder="Cep Telefonu"
                            name="phone"
                            value="0"
                        />
                        <label for="validatorPhone">Cep Telefonu</label>
                        <p id="errorMessage"></p>
                    </div>
                    <div class="form-floating mb-3 passwordInput">
                        <input
                            type="password"
                            class="form-control"
                            id="floatingInput"
                            placeholder="Şifre"
                            name="password"
                        />
                        <label for="floatingInput">Şifre</label>
                        <a href="javascript:;"
                        ><i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <div class="customCheck">
                                    <div class="customCheckInput">
                                        <input type="checkbox" name="remember"/>
                                        <span></span>
                                    </div>
                                    <span> Beni Hatırla </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center justify-content-end">
                            <div class="mb-3">
                                <a href="{{route('business.showForgotForm')}}" class="forgotPass">Şifremi Unuttum</a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" id="senderButton" class="btn-pink w-100 p-4 text-center border-0">
                            Giriş Yap
                        </button>
                    </div>
                </form>
                <div class="mb-0">
                    <label class="registerLabel">Üyeliğiniz Yok Mu?</label>
                    <a href="{{route('business.register')}}" class="btn-gray w-100 p-4 text-center">Ücretsiz Kayıt Ol</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
