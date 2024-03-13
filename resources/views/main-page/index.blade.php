@extends('layouts.master')
@section('title', 'Anasayfa')
@section('content')
    <article>
        @include('main-page.parts.hero')
        @include('main-page.parts.service')
        @include('main-page.parts.proparties')
        @include('main-page.parts.stats')
        @include('main-page.parts.blog')
        @include('main-page.parts.brands')
        @include('components.free-trial-component')
    </article>
@endsection
