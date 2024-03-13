@extends('layouts.master')
@section('title', 'Giriş Yap')
@section('style')

@endsection
@section('content')
    <div class="formBox">
        <div class="formBoxContent d-md-flex align-items-center">
            <div class="formBoxSlider">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/front/assets/images/business/login-slider.jpeg" alt="" />
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/front/assets/images/business/login-slider.jpeg" alt="" />
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="formBoxSliderPhoto">
                            <img src="/front/assets/images/business/login-slider.jpeg" alt="" />
                        </div>
                        <div class="formBoxSliderText">
                            <strong>Hizmet ve Randevu Arama Sitesi. Hızlı Randevu</strong>
                            <span>Etiam nullam donec quis velit sit at tellus. Nunc.</span>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" class="sliderPrev">
                    <svg
                        width="9"
                        height="16"
                        viewBox="0 0 9 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M7.85937 15.2158L0.859375 8.21582L7.85938 1.21582"
                            stroke="white"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
                <a href="javascript:;" class="sliderNext">
                    <svg
                        width="10"
                        height="16"
                        viewBox="0 0 10 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M1.31934 15.2158L8.31934 8.21582L1.31934 1.21582"
                            stroke="white"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
            </div>
            <div class="formBoxForm login-type">
                <div class="mb-4 text-center formLogo">
                    <img src="/front/assets/images/logo-pink.svg" alt="" />
                </div>

                <div class="my-5 text-center">
                    <span class="welcome">Hızlı Randevu’ya hoş geldiniz! </span>
                </div>

                <div class="mb-3">
                    <a href="javascript:;" class="btn-pink w-100 p-4 text-center">
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
