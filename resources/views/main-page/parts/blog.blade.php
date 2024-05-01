@if($comments->count() > 0)
    <section id="homeBlog">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="homeBlogLeft">
                        <div class="homeBlogTitle">
                            <strong>Müşterilerimizin</strong>
                            düşünceleri neler?
                        </div>
                        <p>
                            Kendimizden değil, sektörde tanınmış lider isimlerin yorumlarına kulak verin.
                        </p>
                        <div
                            id="customBlogSliderNav"
                            class="owl-nav d-flex align-items-center my-5"
                        ></div>
                        <a href="javascript:;" class="btn-pink btn-rounded">Tümünü Gör</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="homeBlogSlider">
                        <div class="owl-carousel owl-theme">
                            @foreach($comments as $comment)
                                <div class="item">
                                    <div class="testimonial-item" style="height: 315px;">
                                        <div class="client-info">
                                            <div class="image">
                                                <img
                                                    src="{{image($comment->image)}}"
                                                    alt=""
                                                />
                                            </div>
                                            <div class="content">
                                                <h4>{{$comment->name}}</h4>
                                                <span>{{$comment->created_at->format('d.m.Y')}}</span>
                                            </div>
                                        </div>
                                        <div class="client-comment">
                                            <p>
                                                {{\Illuminate\Support\Str::limit($comment->description, 350)}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
