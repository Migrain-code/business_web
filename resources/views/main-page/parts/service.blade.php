@if($proparties->count() > 0)
    <section class="home-services">
        <div class="container">
            <div class="row">
                <div class="hero">
                    <h3>Özelliklerimizi Keşfedin</h3>

                </div>
            </div>
            <div class="row">
                @foreach($proparties as $proparty)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{route('propartie.detail', $proparty->slug)}}" class="services-item" data-aos="zoom-in">
                            <div class="icon">
                                <img src="{{image($proparty->icon)}}" alt=""/>
                            </div>
                            <h4>{{$proparty->name}}</h4>
                            <p>
                                {{$proparty->description}}
                            </p>
                            <div class="read-more-icon">
                                <img src="/front/assets/images/business/arrow-right.svg" alt=""/>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>


        </div>
    </section>

@endif
