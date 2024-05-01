@extends('layouts.master')
@section('title', 'İşletme Hesabı Oluştur')

@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            @include('components.login-slider')
            <form class="formBoxForm" method="post" action="{{route('business.register.request')}}">
                @csrf
                <div class="mb-0 mt-2">
                    <label class="registerLabel">
                        <h3>Yeni salon kaydı</h3>
                    </label>
                    <label class="registerLabel">30 gün ücretsiz deneme sürenizi başlatın</label>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="floatingInput"
                                placeholder="Salon Sahibinin Adı"
                            />
                            <label for="floatingInput">Salon Sahibinin Adı</label>
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
                            <input type="checkbox" name="terms_and_contitions"/>
                            <span></span>
                        </div>
                        <span>
                            <b>
                                <a href="{{route('page.detail', $pages->skip(1)->first()->slug)}}">Kullanım koşullarını</a>
                            </b> okudum ve kabul ediyorum.
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="customCheck">
                        <div class="customCheckInput">
                            <input type="checkbox" name="privacy_terms"/>
                            <span></span>
                        </div>
                        <span>
                            <b>
                                <a href="{{route('page.detail', $pages->first()->slug)}}">Gizlilik ve kullanım şartlarını</a>
                            </b> okudum ve kabul ediyorum.
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="customCheck">
                        <div class="customCheckInput">
                            <input type="checkbox" name="clarification"/>
                            <span></span>
                        </div>
                        <span>
                            <b>
                                <a href="{{route('page.detail', $pages->skip(2)->first()->slug)}}">Aydınlatma metnini</a>
                            </b> okudum ve kabul ediyorum.
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
