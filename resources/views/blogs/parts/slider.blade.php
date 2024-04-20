<section id="bigSlider" class="mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bigSliderContent">
                    @dd($blogAdvrt)
                    <div class="owl-carousel owl-theme">
                        @foreach($blogAdvrt as $adBanner)
                            <!--Slider ıtem start-->
                            <div class="item">
                                <a href="{{$adBanner->link}}">
                                    <img src="{{image($adBanner->image)}}" alt="" />
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
