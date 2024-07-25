@extends('layouts.master')
@section('title', 'Online Randevu Takip Programı Fiyatları')
@section('description', 'İşletmenizin ihtiyaçlarına uygun ücretsiz çözümleri keşfedin. Profesyonel randevu yönetimi artık hiçbir maliyet gerektirmiyor.')
@section('style')
    <style>
        .home-stats {
            padding: 200px 100px;
            background: #fff;
        }
        .packages-list .package-item ul li:not(:last-of-type) {
            margin-bottom: 10px;
        }
        .packages-list .package-item ul {
            margin-top: 25px;
            padding-left: 20px;
        }
        .packages-list .package-item a {
            display: block;
            border-radius: 108px;
            background: rgba(242, 41, 105, 0.07);
            text-align: center;
            padding: 20px 0;
            text-decoration: none;
            color: #f22969;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            margin-top: auto;
            text-transform: uppercase;
        }
        .toolBarArea{
            display: none;
        }
        @media screen and (max-width: 768px) {
            .customScrollArea{
               width: 1000px;
            }
            .toolBarArea{
                position: relative;
                display: flex;
                justify-content: center;
                margin-top: 50px;
                margin-bottom: -100px;
            }
        }
    </style>

@endsection
@section('content')
        <section class="home-packages">
            <div class="container" style="padding: 60px 40px !important;">
                <section class="home-references" style="padding: 0px !important;">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="references-hero" style="padding: 0px !important;">
                                    <h2>
                                          <span>Ömür Boyu boyunca
                                            <img src="/front/assets/images/business/title-line.svg" alt="" />
                                          </span>
                                        ÜCRETSİZ deneyin!
                                    </h2>
                                    <p>
                                        Kredi kartı gerekmez ve devam etmek <br />
                                        zorunda değilsiniz.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="package-control">
                            <div class="btn-container">
                                <label class="switch btn-color-mode-switch">
                                    <input
                                        value="1"
                                        id="color_mode"
                                        name="color_mode"
                                        type="checkbox"
                                    />
                                    <label
                                        class="btn-color-mode-switch-inner switchClick"
                                        data-off="Aylık"
                                        data-on="Yıllık"
                                        for="color_mode"
                                    ></label>
                                </label>
                                <div class="package-promo">
                                    <span>Yıllık <br />
                                      %20
                                    </span>
                                </div>
                            </div>


                        </div>
                        <div class="d-flex justify-content-center mt-0 mb-3 py-2">
                            Yıllık Ödemelerde <span style="font-weight: bold; margin-left: 5px;color: #f22969"> %20 Kazanın</span>

                        </div>
                    </div>
                </div>
                <!-- Aylık Paketler -->
                <div class="toolBarArea">
                    <div class="sliderArrow">
                        <a href="javascript:;" class="sliderPrev">
                            <img src="/front/assets/images/icons/ico-slider-left.svg">
                        </a>
                        <a href="javascript:;" class="sliderNext" style="background: #828a9e57;">
                            <img src="/front/assets/images/icons/ico-slider-right.svg">
                        </a>
                    </div>
                </div>
                <section class="home-properties packages customPackage1" id="tab1" style="overflow-x: auto;">

                        <div class="row packages-list customScrollArea">
                            @include('prices.parts.package')
                        </div>
                </section>
                <!-- Yıllık Paketler -->
                <section class="home-properties packages customPackage2" id="tab2" style="overflow-x: auto;">
                    <div class="row packages-list customScrollArea">
                        @foreach($yearlyPackages as $package)
                            <div class="col-4" >
                                <div class="package-item">
                                    <div class="icon">
                                        <img src="{{image($package->icon)}}" style="width: 40px;" alt="" />
                                    </div>
                                    <div class="package-info">
                                        <h4>{{$package->name}}</h4>
                                        <span>{{$package->price ==  0 ? "Ücretsiz" : formatPrice($package->price)}}</span>
                                    </div>

                                    <ul>
                                        @foreach($package->proparties as $propartie)
                                            <li>{{$propartie->list->name}}</li>
                                        @endforeach
                                    </ul>

                                    <a href="{{route('business.register')}}">Ömür Boyu Ücretsiz Deneyin</a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </section>

            </div>
        </section>
        @include('main-page.parts.blog')<!-- Yorumlar olarak değişti -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            document.getElementById('tab2').style.display = "none";
        });
        var counter = 0;
        var activeTab = 1;
        $('.switchClick').on('click', function (){
            document.getElementById('tab2').style.display = "none";
            document.getElementById('tab1').style.display = "block";
            activeTab = 1;
            if(counter%2 == 0){
                //yıllık aktif
                document.getElementById('tab1').style.display = "none";
                document.getElementById('tab2').style.display = "block";
                activeTab = 2;
            }

           counter++;

        });
        $('.sliderNext').on('click', function (){
            if(activeTab === 1){
                var currentScrollLeft = $('.customPackage1').scrollLeft();
                currentScrollLeft+= 300;
                if(currentScrollLeft > 900){
                    currentScrollLeft = 0;
                }
                $('.customPackage1').scrollLeft(currentScrollLeft);
            } else{
                var currentScrollLeft2 = $('.customPackage2').scrollLeft();
                currentScrollLeft2+= 300;
                if(currentScrollLeft2 > 900){
                    currentScrollLeft2 = 0;
                }
                $('.customPackage2').scrollLeft(currentScrollLeft2);
            }


        });
        $('.sliderPrev').on('click', function (){

            if(activeTab === 1){
                var currentScrollLeft = $('.customPackage1').scrollLeft();
                currentScrollLeft-= 300;
                if(currentScrollLeft > 900){
                    currentScrollLeft = 0;
                }
                $('.customPackage1').scrollLeft(currentScrollLeft);
            } else{
                var currentScrollLeft2 = $('.customPackage2').scrollLeft();
                currentScrollLeft2-= 300;

                $('.customPackage2').scrollLeft(currentScrollLeft2);
            }


        });
    </script>

@endsection
