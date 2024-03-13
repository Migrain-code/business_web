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
                        @include('proparties.parts.links')
                    </div>
                </div>
            </div>
        </section>

        @include('proparties.parts.tabs')
    </article>
@endsection
