@extends('layouts.master')
@if(request()->routeIs('blogs.category'))
    @section('title', $blogCategories->first()->getMetaTitle())
    @section('description', $blogCategories->first()->getMetaDescription())
@else
    @section('title', 'Blog: İşletme Yönetimi ve Randevu Takibi Hakkında İlham Verici İçerikler')
    @section('description', '"Blogumuzda işletme yönetimi ve randevu takibi konularında güncel ve ilham verici içerikler bulabilirsiniz. İşletmenizi büyütmek ve yönetmek için faydalı ipuçlarına göz atın!"')
@endif

@section('styles')

@endsection
@section('content')
    <article id="page">
        @include('blogs.parts.breadcrumb')
        @include('blogs.parts.slider')

        <section id="pageContent">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="pageTitle mb-5">Blog Yazıları</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pageTab blog-area">
                            @include('blogs.parts.links')
                            @include('blogs.parts.tabs')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>

@endsection

@section('scripts')

@endsection
