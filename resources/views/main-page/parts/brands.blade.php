@if($brands->count() > 0)
    <section id="brandList">
        <div class="container">
            <div class="row">
                <div class="hero">
                    <h3>Yüzlerce İşletme Güvencemiz Altında! !</h3>
                    <p>800+ İşletme Bizimle Yıllardır Çalışmaktadır.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="brandListSlider">
                        <div class="owl-carousel owl-theme">
                            @foreach($brands as $brand)
                                <div class="item">
                                    <a href="{{$brand->link}}" target="_blank">
                                        <img src="{{image($brand->image)}}" alt=""/>
                                    </a>
                                </div>
                            @endforeach


                        </div>
                        <a href="javascript:;" class="sliderPrev">
                            <img src="/front/assets/images/icons/ico-slider-left.svg"/>
                        </a>
                        <a href="javascript:;" class="sliderNext">
                            <img src="/front/assets/images/icons/ico-slider-right.svg"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
