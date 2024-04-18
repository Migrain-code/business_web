
@foreach($proparties as $propartie)
    <section class="tab-content @if($loop->index == 0) active @endif" id="tab{{$propartie->id}}">
        <!-- İtem Start -->
        <section class="home-properties packages">
            <div class="container">
                <div class="row properties-item">
                    <div class="col-lg-6">
                        <div class="content" data-aos="zoom-in-right">
                            <h3>{{$propartie->name}}</h3>
                            <span>
                                                            {{$propartie->description}}
                                                        </span>
                            <p>
                                {!! $propartie->detail !!}
                            </p>

                            <a href="{{$propartie->btn_link}}">{{$propartie->btn_text}} </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="image" data-aos="zoom-in-left">
                            <img src="{{image($propartie->image)}}" alt=""/>
                            <div class="shape-1"></div>
                            <div class="shape-2"></div>
                            <div class="shape-3"></div>
                            <div class="shape-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endforeach


