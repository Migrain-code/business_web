@extends('layouts.master')
@section('title', 'Fiyatlandırma')
@section('style')

@endsection
@section('content')
    <article>
        <section class="home-packages">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero">
                            <h3>Paketler & Özellikleri</h3>
                            <p>
                                Detaylı İncelemek isterseniz özellikler <br />
                                sekmesinden görebilirsiniz.
                            </p>
                        </div>
                    </div>
                </div>

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
                                      %35
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Aylık Paketler -->
                <section class="home-properties packages" id="tab1">
                        <div class="row packages-list">
                            @include('prices.parts.package')
                        </div>
                </section>
                <!-- Yıllık Paketler -->
                <section class="home-properties packages" id="tab2">
                    <div class="row packages-list">

                    </div>
                </section>
                @include('main-page.parts.stats')
            </div>
        </section>

        @include('main-page.parts.stats')
        @include('main-page.parts.service')
    </article>

@endsection

@section('scripts')
    <script>
        var counter = 0;
        $('.switchClick').on('click', function (){
            document.getElementById('tab2').style.display = "none";
            document.getElementById('tab1').style.display = "block";
            if(counter%2 == 0){
                //yıllık aktif
                document.getElementById('tab1').style.display = "none";
                document.getElementById('tab2').style.display = "block";
            }

           counter++;
           console.log('counter', counter)
        });
    </script>
@endsection
