@extends('layouts.master')
@section('title', $blog->getMetaTitle())
@section('description', strip_tags($blog->getDescription()))
@section('content')
    <article id="page">
        @include('blogs.detail.parts.breadcrumb')
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <section id="pageContent">
                        <div class="row mb-5">
                            <div class="col-12 border-end">
                                <div class="pe-md-4">
                                    @include('blogs.detail.parts.banner')
                                    @include('blogs.detail.parts.links')

                                    <h2 class="pageTitle mb-5">
                                       {{$blog->getTitle()}}
                                    </h2>
                                    <div class="pageText">
                                        {!! $blog->getDescription() !!}
                                    </div>
                                    @include('blogs.detail.parts.social')
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-3">
                    @include('blogs.detail.parts.categories')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="pageSubTitle text-center mt-5 pt-5 mb-4">
                        Benzer Yazılar
                    </div>
                    <div class="blogListSlider">
                        <div class="owl-carousel owl-theme">
                            @forelse($blog->category->blogs()->take(5)->get() as $blogRow)
                                <div class="item">
                                    <x-blog-component
                                        image="{{image($blogRow->image)}}"
                                        link="{{route('blogs.detail', $blogRow->getSlug())}}"
                                        categoryName="{{$blog->category->getName()}}"
                                        date="{{$blogRow->created_at->format('d.m.Y')}}"
                                        title="{{$blogRow->getTitle()}}"
                                        shortDescription="{{\Illuminate\Support\Str::limit(strip_tags($blogRow->getDescription()), 100)}}">
                                    </x-blog-component>
                                </div>

                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const hElements = document.querySelectorAll('h1, h2, h3, h4, h5');

            for (let i = 0; i < hElements.length; i++) {
                hElements[i].setAttribute('id', `head-${i}`);
            }
        });
    </script>
@endsection
