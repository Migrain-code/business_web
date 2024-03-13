@extends('layouts.master')
@section('title', 'Blog Detayı')
@section('styles')

@endsection
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
                                        Nulla leo vivamus gravida pellentesque posuere consequat
                                        quis. Enim dolor tellus.
                                    </h2>
                                    <div class="pageText">
                                        Massa amet eget aliquam aliquam. Etiam auctor cras quam
                                        tempus. Sagittis et at eget purus id. Turpis amet quis
                                        urna sem vitae sed sit ut. Cursus risus vulputate euismod
                                        sit sit tristique. Bibendum sit posuere semper eget enim
                                        at. Sit dui nulla bibendum quis in. Amet elit mattis nunc
                                        lectus nunc congue pharetra. Purus est amet nibh sed quam
                                        elit. Adipiscing condimentum vestibulum dignissim in.
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
                            <div class="item">
                                <x-blog-component
                                    image="{{asset('front/assets/images/blogitem.png')}}"
                                    link="asdasd"
                                    categoryName="Saç Kesimi"
                                    date="18.01.01"
                                    title="Fusce diam ultricies magna senectus."
                                    shortDescription="Fusce diam ultricies magna senectus.">
                                </x-blog-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

@section('scripts')

@endsection
