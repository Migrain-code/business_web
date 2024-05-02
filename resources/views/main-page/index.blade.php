@extends('layouts.master')
@section('title', 'Anasayfa')
@section('style')
    <style>
        #brandList .brandListSlider .owl-carousel .item a{
            min-width: 220px !important;
            max-width: 220px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: auto;
            aspect-ratio: 1 / 1;
        }
        .home-stats {
            padding: 10px 100px;
            padding-bottom: 80px;
            background: #fff;
        }
    </style>
@endsection
@section('content')
    <article>
        @include('main-page.parts.hero')
        @include('main-page.parts.service')
        @include('main-page.parts.proparties')
        @include('main-page.parts.stats')<!-- Video ve counter -->
        @include('main-page.parts.blog')<!-- Yorumlar olarak değişti -->
        @include('main-page.parts.brands')<!-- Markalar -->
        @include('components.free-trial-component')
    </article>
@endsection
