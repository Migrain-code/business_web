@extends('layouts.master')
@section('title', $page->meta_keys)
@section('styles')

@endsection
@section('content')
    <article id="page" class="p-5">
    <div class="card" style="border: 0px">
        <div class="card-header" style="background: none;border-bottom:1px solid rgba(185,183,183,0.72)">
            <div class="card-title">
               <h2> {{$page->title}}</h2>
            </div>
        </div>
        <div class="card-body">
            {!! $page->description !!}
        </div>
    </div>
    </article>
@endsection

@section('scripts')

@endsection
