@extends('layouts.master')
@section('title', 'Telefon Numaranı Doğrula')

@section('content')
    <div class="formBox">
        <div class="formBoxContent d-flex align-items-center w-auto forgotPass">
            <div class="formBoxForm w-auto">
                <div class="verification-box">
                    <div class="aut-image">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-device-mobile-message"
                            width="96"
                            height="96"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="#56467d"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M11 3h10v8h-3l-4 2v-2h-3z" />
                            <path
                                d="M15 16v4a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h2"
                            />
                            <path d="M10 18v.01" />
                        </svg>
                    </div>

                    <div class="aut-content">
                        <h2>Telefon Numarası Doğrulama</h2>
                        <p>Gönderdiğimiz doğrulama kodunu giriniz.</p>
                        <span>{{maskPhone(session('phone'))}}</span>
                    </div>

                    <form method="post" action="{{route('business.twoFactorVerification.verify')}}" class="aut-verification">
                        @csrf
                        <div class="aut-info">
                            <p>6 haneli güvenlik kodunuzu yazınız.</p>
                        </div>
                        <div class="aut-number">
                            <input type="text" name="digit_code[]" class="cellInput" maxlength="1" />
                            <input type="text" name="digit_code[]" class="cellInput" maxlength="1" />
                            <input type="text" name="digit_code[]" class="cellInput" maxlength="1" />
                            <input type="text" name="digit_code[]" class="cellInput" maxlength="1" />
                            <input type="text" name="digit_code[]" class="cellInput" maxlength="1" />
                            <input type="text" name="digit_code[]" class="cellInput" maxlength="1" />
                        </div>
                        <div class="aut-buttons d-flex">
                            <button type="submit" style="border: 0px;" class="btn-pink">Gönder</button>
                            <a href="#" class="btn-gray">Temizle</a>
                        </div>
                    </form>

                    <div class="aut-resend">
                        <p>Kodu almadınız mı? <a href="javascript:void(0)" onclick="resendVerifyCode()">Tekrar Gönder</a></p>
                        <form type="hidden" id="resendForm" method="post" action="{{route('business.twoFactorVerification.resend')}}">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $(".cellInput").inputmask({"mask": "9"});
        });
        function resendVerifyCode(){
            $('#resendForm').submit();
        }
    </script>
@endsection
