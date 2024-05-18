@extends('business.layouts.master')
@section('title', 'Abonelik Özeti')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Gösterge Paneli </a>
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
           @if(isset($package))
               <div class="col-lg-4">
                   <div class="card min-h-400px">
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

                               <div class="col-12 mt-3">
                                   @php
                                       $totalDay = $package->type == 0 ? 30 : 365;
                                       $progressPercentage = ($remainingDay / $totalDay) * 100;
                                   @endphp
                                   <div class="progress w-100px w-xl-150px w-xxl-300px h-30px bg-gray-300 position-relative">
                                       <div class="progress-bar bg-success text-white fs-7 fw-bold" role="progressbar"
                                            style="width: {{$progressPercentage}}%;" aria-valuenow="{{$progressPercentage}}" aria-valuemin="0" aria-valuemax="{{$totalDay}}">
                                       </div>
                                       <span class="position-absolute fs-7" style="top: 12%;left: 27%">Kalan Gün Sayısı: {{$remainingDay}} Gün</span>

                                   </div>
                               </div>
                           </div>

                           @if($package->id != 1 && $package->id != 6)
                               <!--begin::Separator-->
                               <div class="separator separator-dashed my-4"></div>
                               <!--end::Separator-->
                               <div class="row d-flex">
                                   <div class="col ">
                                       <a class="btn btn-primary w-100 mt-5 freePackageChange" href="javascript:void(0)">Ücretsiz Pakete Geç</a>
                                   </div>
                               </div>
                           @endif

                       </div>
                   </div>
               </div>
           @endif

           <!--end::Card-->
           <div class="@if(isset($package)) col-lg-8 @else col-lg-12 @endif ">
               <div class="card">
                   <div class="card-body">
                       <!--begin::Plans-->
                       <div class="d-flex flex-column">
                           <!--begin::Heading-->
                           <div class="mb-13 text-center">
                               <h1 class="fs-2hx fw-bold mb-5">Planınızı Seçin</h1>
                               <div class="text-gray-400 fw-semibold fs-5">Fiyatlandırmamız hakkında daha fazla bilgiye ihtiyacınız varsa, lütfen kontrol edin
                                   <a href="#" class="link-primary fw-bold">Fiyatlandırma Yönergeleri</a>.</div>
                           </div>
                           <!--end::Heading-->
                           <!--begin::Nav group-->
                           <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true">
                               <button class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active monthlyBtn" data-kt-plan="month">Aylık</button>
                               <button class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 yearlyBtn" data-kt-plan="annual">Yıllık</button>
                           </div>
                           <!--end::Nav group-->
                           <!--begin::Row-->
                           <div id="priceTab1" class="row g-10">
                               @foreach($monthlyPackages as $mPackage)
                                   <!--begin::Col-->
                                   <div class="@if(isset($package)) col-md-6 @else col-md-4 @endif ">
                                       <div class="d-flex ">
                                           <!--begin::Option-->
                                           <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                               <!--begin::Heading-->
                                               <div class="mb-7 text-center">
                                                   <!--begin::Title-->
                                                   <h1 class="text-dark mb-5 fw-bolder">{{$mPackage->name}}</h1>
                                                   <!--end::Title-->
                                                   <!--begin::Price-->
                                                   <div class="text-center">

                                                       <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{$mPackage->price}}</span>
                                                       <span class="mb-2 text-primary fs-3">₺</span>
                                                       <span class="fs-7 fw-semibold opacity-50">/
																		<span data-kt-element="period">Ay</span></span>
                                                   </div>
                                                   <!--end::Price-->
                                               </div>
                                               <!--end::Heading-->
                                               <!--begin::Features-->
                                               <div class="w-100 mb-10">
                                                   @foreach($mPackage->proparties as $propartie)
                                                       <!--begin::Item-->
                                                       <div class="d-flex align-items-center mb-5">
                                                           <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{$propartie->list->name}}</span>
                                                           <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                           <span class="svg-icon svg-icon-1 svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                                           <!--end::Svg Icon-->
                                                       </div>
                                                       <!--end::Item-->
                                                   @endforeach


                                               </div>
                                               <!--end::Features-->
                                               <!--begin::Select-->
                                               <a href="{{route('business.packet.buy', $mPackage->id)}}" class="btn btn-sm btn-primary">Bu Pakete Geç</a>
                                               <!--end::Select-->
                                           </div>
                                           <!--end::Option-->
                                       </div>
                                   </div>
                                   <!--end::Col-->
                               @endforeach
                           </div>
                           <div id="priceTab2" class="row" style="display: none">
                               @foreach($yearlyPackages->where('type',1) as $yPackage)
                                   <!--begin::Col-->
                                   <div class="@if(isset($package)) col-md-6 @else col-md-4 @endif ">
                                       <div class="d-flex ">
                                           <!--begin::Option-->
                                           <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                               <!--begin::Heading-->
                                               <div class="mb-7 text-center">
                                                   <!--begin::Title-->
                                                   <h1 class="text-dark mb-5 fw-bolder">{{$yPackage->name}}</h1>
                                                   <!--end::Title-->
                                                   <!--begin::Price-->
                                                   <div class="text-center">
                                                       <span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">{{$yPackage->price}}</span>
                                                       <span class="mb-2 text-primary fs-3">₺</span>
                                                       <span class="fs-7 fw-semibold opacity-50">/
																		<span data-kt-element="period">{{$yPackage->price == 0 ? "Ay" : "Yıl"}}</span></span>
                                                   </div>
                                                   <!--end::Price-->
                                               </div>
                                               <!--end::Heading-->
                                               <!--begin::Features-->
                                               <div class="w-100 mb-10">
                                                   @foreach($yPackage->proparties as $propartie)
                                                       <!--begin::Item-->
                                                       <div class="d-flex align-items-center mb-5">
                                                           <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">{{$propartie->list->name}}</span>
                                                           <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                                                           <span class="svg-icon svg-icon-1 svg-icon-success">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                                    <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                                           <!--end::Svg Icon-->
                                                       </div>
                                                       <!--end::Item-->
                                                   @endforeach


                                               </div>
                                               <!--end::Features-->
                                               <!--begin::Select-->
                                               <a href="{{route('business.packet.buy', $yPackage->id)}}" class="btn btn-sm btn-primary">Bu Pakete Geç</a>
                                               <!--end::Select-->
                                           </div>
                                           <!--end::Option-->
                                       </div>
                                   </div>
                                   <!--end::Col-->
                               @endforeach
                           </div>
                           <!--end::Row-->
                       </div>
                       <!--end::Plans-->
                   </div>
               </div>
           </div>
       </div>
    </div>

@endsection
@section('scripts')
    <script>
        $('.monthlyBtn').on('click', function (){
            $('#priceTab1').css('display', 'flex');
            $('#priceTab2').css('display', 'none');
        });
        $('.yearlyBtn').on('click', function (){
            $('#priceTab2').css('display', 'flex');
            $('#priceTab1').css('display', 'none');
        });
        $('.freePackageChange').on('click', function (){
            @if($remainingDay != 0)
                Swal.fire({
                    'icon': "warning",
                    'title': "Bu pakete geçemezsiniz",
                    'html':"Mevcut Tanımlı Paketinizin "+"<b>{{$remainingDay}}</b>"+ " Gün Süresi Dolmadan Ücretsiz Pakete Geçiş Yapamazsınız!",
                    confirmButtonText: "Tamam",
                });
            @endif
        });
    </script>
@endsection
