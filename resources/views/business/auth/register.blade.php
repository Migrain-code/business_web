@extends('layouts.master')

@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('components.login-slider')
            <form class="formBoxForm" method="post" action="{{route('business.register.request')}}">
                @csrf
                <div class="mb-4 text-center formLogo">
                    <img src="/front/assets/images/logo-pink.svg" alt="" />
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="floatingInput"
                                placeholder="Cep Telefonu"
                            />
                            <label for="floatingInput">Ad Soyad</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                id="validatorPhone"
                                placeholder="Cep Telefonu"
                            />
                            <label for="validatorPhone">Telefon Numarası</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                id="floatingInput"
                                placeholder="E-Mail"
                            />
                            <label for="floatingInput">E-Mail</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                id="floatingInput"
                                placeholder="Parola"
                            />
                            <label for="floatingInput">Parola</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                name="business_name"
                                class="form-control"
                                id="floatingInput"
                                placeholder="Firma Adı"
                            />
                            <label for="floatingInput">Firma Adı</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="customCheck">
                        <div class="customCheckInput">
                            <input type="checkbox" name="is_permission"/>
                            <span></span>
                        </div>
                        <span>
                            Kampanyalardan haberdar olmak için tarafıma ticari ileti
                            gönderilsin
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="customCheck">
                        <div class="customCheckInput">
                            <input type="checkbox" name="terms"/>
                            <span></span>
                        </div>
                        <span>
                            Kolay Randevu <a href="javacript:;"> kullanım koşullarını</a>,
                                          <a href="javacript:;">gizlilik ve KVKK politikasını</a>
                                          <a href="javacript:;">ve aydınlatma metnini</a> okudum, bu
                            kapsamda verilerimin işlenmesini onaylıyorum
              </span>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" style="border: 0px;" class="btn-pink w-100 p-4 text-center">Kayıt Ol</button>
                </div>
                <div class="mb-0">
                    <label class="registerLabel">Üyeliğiniz Var Mı?</label>
                    <a href="{{route('business.login')}}" class="btn-gray w-100 p-4 text-center">Giriş Yap</a>
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
