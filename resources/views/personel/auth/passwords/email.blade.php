@extends('layouts.master')

@section('content')
    <div class="formBox">
        <div class="formBoxContent d-flex align-items-center w-auto forgotPass">
            <form method="post" action="{{route('business.sendResetVerifyCode')}}" class="formBoxForm w-auto">
                @csrf
                <div class="mb-5 text-center formLogo">
                    <img src="/front/assets/images/logo-pink.svg" alt="" />
                </div>
                <label class="registerLabel">Şifremi Unuttum</label>
                <div class="form-floating mb-3">
                    <input
                        type="text"
                        class="form-control"
                        id="validatorPhone"
                        name="phone"
                        placeholder="Cep Telefonu"
                    />
                    <label for="validatorPhone">Cep Telefonu</label>
                </div>

                <div class="back-sign-page">
                    <a href="{{route('business.login')}}">Giriş ekranına geri dön</a>
                </div>

                <div class="mb-3">
                    <button type="submit" style="border:0px" class="btn-pink w-100 p-4 text-center">Kodu Gönder</button>
                </div>

                <div class="mt-5">
                    <label class="registerLabel">Üyeliğiniz Yok Mu?</label>
                    <a href="{{route('business.register')}}" class="btn-gray w-100 p-4 text-center">Ücretsiz Kayıt Ol</a>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>

    <script>
        $(document).ready(function(){
            $("#validatorPhone").inputmask({"mask": "0999 999 9999"});
        });
    </script>
@endsection