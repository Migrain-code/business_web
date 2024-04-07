@extends('business.layouts.master')
@section('title', 'Destek Merkezi | Öğretici Videolar')
@section('styles')

@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Dashboard </a>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.support-center.index')}}">Destek Merkezi</a>
    </li>
    <!--end::Item-->
    <!--end::Item-->
    <li class="breadcrumb-item">
        <i class="ki-duotone ki-right fs-3 text-gray-500 mx-n1"></i></li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Öğretici Videolar
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        @include('business.support-center.layouts.header')
        <!--begin::Home card-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Section-->
                <div class="mb-17">
                    <!--begin::Content-->
                    <div class="d-flex flex-stack mb-5">
                        <!--begin::Title-->
                        <h3 class="text-dark">Video Öğreticiler</h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Content-->

                    <!--begin::Separator-->
                    <div class="separator separator-dashed mb-9"></div>
                    <!--end::Separator-->

                    <!--begin::Row-->
                    <div class="row g-10">
                        @forelse($videos as $video)
                            <!--begin::Col-->
                            <div class="col-md-4">
                                <!--begin::Feature post-->
                                <div class="card-xl-stretch me-md-6">
                                    <!--begin::Image-->
                                    <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-175px mb-5"
                                       style="background-image:url('/business/assets/media/stock/600x400/img-73.jpg')"
                                       data-fslightbox="lightbox-video-tutorials"
                                       href="https://www.youtube.com/embed/btornGtLwIo">

                                        <img src="/business/assets/media/svg/misc/video-play.svg" class="position-absolute top-50 start-50 translate-middle" alt="">
                                    </a>
                                    <!--end::Image-->

                                    <!--begin::Body-->
                                    <div class="m-0">
                                        <!--begin::Title-->
                                        <a href="javascript:void(0)" class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">
                                            {{$video->title}}
                                        </a>
                                        <!--end::Title-->

                                        <!--begin::Text-->
                                        <div class="fw-semibold fs-5 text-gray-600 text-dark my-4">
                                            {{$video->description}}
                                        </div>
                                        <!--end::Text-->

                                        <!--begin::Content-->
                                        <div class="fs-6 fw-bold">
                                            <!--begin::Date-->
                                            <span class="text-muted">{{$video->created_at->format('d.m.Y')}}</span>
                                            <!--end::Date-->
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Feature post-->

                            </div>
                            <!--end::Col-->
                        @empty
                            @include('business.layouts.components.alerts.empty-alert')
                        @endforelse
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Section-->
            </div>

    </div>
@endsection
@section('scripts')
    <script src="/business/assets/js/project/fslightbox/fslightbox.bundle.js"></script>
@endsection
