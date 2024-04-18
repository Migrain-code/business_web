@extends('business.layouts.master')
@section('title', 'Abonelik Özeti')
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
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        Abonelik
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content">
        <!--begin::Card-->
       <div class="row">
           <div class="col-4">
               <div class="card min-h-500px">
                   <div class="card-header p-5 fs-3">
                       <ul>
                           @foreach($package->proparties as $propartie)
                               <li> {{$propartie->list->name}}</li>
                           @endforeach
                       </ul>
                   </div>
                   <!--begin::Card header-->
                   <div class="card-body">
                       <div class="row">
                           <div class="col d-flex flex-stack">
                               <h2>{{$package->name}}</h2>
                               <h2>{{$package->price. "₺"}} / {{$package->type == 0 ? "Aylık": "Yıllık"}}</h2>
                           </div>
                       </div>
                       <!--begin::Separator-->
                       <div class="separator separator-dashed my-4"></div>
                       <!--end::Separator-->
                       <div class="row d-flex align-items-center">
                           <div class="col-4">
                               <h1>{{$remainingDay}}</h1>
                               <span class="fs-3">Kalan Gün</span>
                           </div>
                           <div class="col-8">
                               @php
                                   $totalDay = $package->type == 0 ? 30 : 365;
                                   $progressPercentage = ($remainingDay / $totalDay) * 100;
                               @endphp
                               <div class="h-30px mx-3 w-100 bg-gray-200 rounded">
                                   <div class="bg-primary rounded h-30px" role="progressbar" style="width: {{$progressPercentage}}%;" aria-valuenow="{{$remainingDay}}" aria-valuemin="0" aria-valuemax="{{$totalDay}}"></div>
                               </div>
                           </div>
                       </div>
                       <!--begin::Separator-->
                       <div class="separator separator-dashed my-4"></div>
                       <!--end::Separator-->
                       <div class="row d-flex">
                           <div class="col ">
                               <a class="btn btn-primary w-100 mt-5" href="{{route('business.home')}}">Panele Git</a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <!--end::Card-->
           <div class="col-8">
               <div class="card">
                   <div class="card-body">
                       {!! $terms !!}
                   </div>
               </div>
           </div>
       </div>
    </div>

@endsection
@section('scripts')
    <script>

    </script>
@endsection
