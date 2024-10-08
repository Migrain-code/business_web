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
            {{--
                @include('business.subscription.components.user-subscribtion')
            @include('business.subscription.components.packages')
            --}}
            <x-forbidden-component title="Erişim Yetkiniz Yok" message="Abonelik Menüsüne Erişmek İçin Yetkiniz Bulunmamaktadır"></x-forbidden-component>
           <!--end::Card-->
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
