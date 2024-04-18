@extends('layouts.master')
@section('title', 'Anasayfa')
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
