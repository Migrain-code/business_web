@extends('layouts.master')
@section('title', 'Referanslar')
@section('styles')

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
                            <p>
                                Ipsum nascetur pharetra vivamus tristique <br />
                                maecenas at euismod eu non. Gravida auctor.
                            </p>
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
