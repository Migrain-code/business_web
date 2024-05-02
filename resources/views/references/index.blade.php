@extends('layouts.master')
@section('title', 'Referanslar')
@section('style')
    <style>
        .home-references .references-items .item::after {
            content: "";
            display: inline-block;
            position: absolute;
            right: -37%;
            top: 50%;
            transform: translateY(-50%);
            height: 50px;
            width: 1px;
            background: rgba(67, 80, 110, 0.15);
        }
    </style>
@endsection
@section('content')
    <article>
        <section class="home-references">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="references-hero">
                            <h2>
                                  <span>Referanslarımızı
                                    <img src="/front/assets/images/business/title-line.svg" alt="" />
                                  </span>
                                Keşfedin
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="references-items">
                        @foreach($brands as $brand)
                            @include('references.parts.item')
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </article>
@endsection

@section('scripts')

@endsection
