<section id="bigSlider" class="mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bigSliderContent">

                    <div class="owl-carousel owl-theme">
                        @foreach($blogAdvrt as $advert)
                            <!--Slider ıtem start-->
                            <div class="item">
                                <a href="{{$advert->link}}">
                                    <img src="{{image($advert->image)}}" alt="" />
                                </a>
                            </div>
                            <!--Slider ıtem end-->
                        @endforeach

                    </div>
                    <div class="sliderArrow">
                        <a href="javascript:;" class="sliderPrev">
                            <img src="/front/assets/images/icons/ico-slider-left.svg" />
                        </a>
                        <a href="javascript:;" class="sliderNext">
                            <img src="/front/assets/images/icons/ico-slider-right.svg" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
