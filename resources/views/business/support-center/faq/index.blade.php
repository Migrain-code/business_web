@extends('business.layouts.master')
@section('title', 'Destek Merkezi | Sık Sorulan Sorular')
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
        Sık Sorulan Sorular
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content ">
        @include('business.support-center.layouts.header')
        <!--begin::Home card-->
        <!--begin::FAQ card-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-10 p-lg-15">
                <!--begin::Classic content-->
                <div class="mb-13">
                    <!--begin::Intro-->
                    <div class="mb-15">
                        <!--begin::Title-->
                        <h4 class="fs-2x text-gray-800 w-bolder mb-6">
                            Sık Sorulan Sorular
                        </h4>
                        <!--end::Title-->

                        <!--begin::Text-->
                        <p class="fw-semibold fs-4 text-gray-600 mb-2">
                            "Destek merkezimize ulaşmadan önce, sıkça sorulan sorular bölümümüzü ziyaret ederek sorunlarınıza hızlı bir şekilde çözüm bulabilirsiniz. Burada genellikle karşılaşılan sorunların yanıtlarını bulabilir ve zaman kazanabilirsiniz. Eğer hâlâ sorununuz devam ediyorsa, bizimle iletişime geçmekten çekinmeyin. Yardımcı olmaktan mutluluk duyarız!"
                        </p>
                        <!--end::Text-->
                    </div>
                    <div class="row">
                        @php
                            $categoryCount = $faqCategories->count();
                            $halfCategoryCount = ceil($categoryCount / 2);
                        @endphp
                        <!-- Sol sütun -->
                        <div class="col-md-6 mb-10">
                            @for($i = 0; $i < $halfCategoryCount; $i++)
                                @php $category = $faqCategories->get($i); @endphp
                                    <!-- Kategori içeriği buraya gelecek -->
                                <div class="col-md-12 mb-10">
                                    <!-- Kategori içeriği buraya gelecek -->
                                    <h2 class="text-gray-800 fw-bold mb-4">
                                        {{$category->getName()}}
                                    </h2>
                                    <!-- Accordion -->
                                    @include('business.support-center.faq.parts.accordion-items')
                                    <!-- /Accordion -->
                                </div>
                            @endfor
                        </div>

                        <!-- Sağ sütun -->
                        <div class="col-md-6 mb-10">
                            @for($i = $halfCategoryCount; $i < $categoryCount; $i++)
                                @php $category = $faqCategories->get($i); @endphp
                                    <!-- Kategori içeriği buraya gelecek -->
                                <div class="col-md-12 mb-10">
                                    <!-- Kategori içeriği buraya gelecek -->
                                    <h2 class="text-gray-800 fw-bold mb-4">
                                        {{$category->getName()}}
                                    </h2>
                                    <!-- Accordion -->
                                    @include('business.support-center.faq.parts.accordion-items')

                                    <!-- /Accordion -->
                                </div>
                            @endfor
                        </div>
                    </div>

                </div>
                <!--end::Classic content-->

            </div>
            <!--end::Body-->
        </div>
        <!--end::FAQ card-->
@endsection
@section('scripts')

@endsection
