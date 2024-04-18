@extends('layouts.master')
@section('title', 'Özellikler')
@section('style')
    <style>
        .home-page .home-items {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: start !important;
            border-bottom: 1px solid rgba(67, 80, 110, 0.15);
            padding-bottom: 30px;
        }
    </style>
@endsection
@section('content')
    <article>
        <section class="home-page packages">
            <div class="container">
                <div class="row">
                    <div class="home-items">
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

                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection
