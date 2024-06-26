<section class="home-stats">
    <div class="container">
        @if(strpos(setting('business_main_page_video_link'), "https://") === 0)
        <div class="row">
            <div class="hero" style="margin-bottom: 0px !important;">
                <h3>{{setting('business_main_page_video_title')}}</h3>
                <p>{{setting('business_main_page_video_sub_title')}}</p>
            </div>
        </div>
        @else
            <div class="row">
                <div class="hero" style="margin-bottom: 0px !important;">
                    <h3>Hızlı Randevu Zamanı Tasarlar !</h3>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                @if(strpos(setting('business_main_page_video_link'), "https://") === 0)
                <div class="video-area" data-bs-toggle="modal" data-bs-target="#videoModal">
                    <img src="{{image(setting('business_main_page_video_image'))}}" alt=""/>
                    <a href="javascript:;" class="play-video">
                        <img src="/front/assets/images/business/video-button.svg" alt=""/>
                    </a>
                </div>
                @endif
                @if($stats->count() > 0)
                    <div class="row stats-items">
                        @foreach($stats as $stat)
                            <div class="col-lg-3">
                                <div class="stats-item" data-aos="zoom-in">
                                    <div class="icon">
                                        <img src="{{image($stat->icon)}}" alt=""/>
                                    </div>
                                    <h2>%{{$stat->percentage}}</h2>
                                    <p>{{$stat->title}}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
