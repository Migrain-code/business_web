@extends('business.layouts.master')
@section('title', 'Ödeme')
@section('styles')

@endsection
@section('content')
    <!--begin::Pricing card-->
    <div class="card" id="kt_pricing">
        <!--begin::Card body-->
        <div class="card-body p-lg-17">
           <div class="row">
               <!--begin::Sidebar-->
               <div class="col-lg-4 mb-10 order-1 order-lg-2">
                   <!--begin::Card-->
                   <div class="card card-flush pt-3 mb-0 bg-gray-100" data-kt-sticky="true" data-kt-sticky-name="subscription-summary" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                       <!--begin::Card header-->
                       <div class="card-header">
                           <!--begin::Card title-->
                           <div class="card-title">
                               <h2>Sipariş Özeti</h2>
                           </div>
                           <!--end::Card title-->
                       </div>
                       <!--end::Card header-->
                       <!--begin::Card body-->
                       <div class="card-body pt-0 fs-6">
                           <!--begin::Section-->
                           <!--begin::Seperator-->
                           <div class="separator separator-dashed mb-7"></div>
                           <!--end::Seperator-->
                           <!--begin::Section-->
                           <div class="mb-7">
                               <!--begin::Title-->
                               <h5 class="mb-3">Paket Bilgileri</h5>
                               <!--end::Title-->
                               <!--begin::Details-->
                               <div class="mb-0">
                                   <!--begin::Plan-->
                                   <span class="badge badge-light-info me-2">{{$packet->name}}</span>
                                   <!--end::Plan-->
                                   <!--begin::Price-->
                                   <span class="fw-semibold text-gray-600">{{formatPrice($packet->price)}} / {{$packet->type == 0 ? "Aylık" : "Yıllık"}}</span>
                                   <!--end::Price-->
                               </div>
                               <!--end::Details-->
                           </div>
                           <!--end::Section-->
                           <!--begin::Seperator-->
                           <div class="separator separator-dashed mb-7"></div>
                           <!--end::Seperator-->
                           <!--begin::Section-->
                           <div class="mb-10">
                               <!--begin::Title-->
                               <h5 class="mb-3">Ödeme Detayı</h5>
                               <!--end::Title-->
                               <!--begin::Details-->
                               <div class="mb-0">
                                   <!--begin::Card info-->
                                    <div class="d-flex flex-stack mb-2">
                                        <label for="">Genel Toplam</label>
                                        <label>{{formatPrice($generalTotal)}} </label>
                                    </div>
                                   <div class="d-flex flex-stack mb-2">
                                       <label for="">Vergi Tutarı (20%)</label>
                                       <label>{{formatPrice($taxTotal)}} </label>
                                   </div>
                                   <div class="d-flex flex-stack mb-2">
                                       <label for="">İndirim ({{$discountRate}}%)</label>
                                       <label>{{formatPrice($discountTotal)}} </label>
                                   </div>
                                   @if(session('coupon'))
                                       <form method="post" action="{{route('business.packet.removeCoupon', $packet->id)}}">
                                           @csrf
                                           <div class="d-flex flex-stack mb-2 bg-gray-300 p-4 rounded">
                                               <label for="">#{{session('coupon')->code}}</label>
                                               <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Kuponu Kaldır"><i class="fa fa-xmark-circle"></i></button>
                                           </div>
                                       </form>

                                   @else
                                       <div class="input-group mb-5">
                                           <form method="post" action="{{route('business.packet.useCoupon', $packet->id)}}">
                                               @csrf
                                               <div class="d-flex">
                                                   <input type="text" class="form-control" name="coupon_code" required
                                                          placeholder="Kupon Kodu"
                                                          aria-label="Kupon Kodu"
                                                          aria-describedby="basic-addon2">
                                                   <span class="input-group-text p-0" id="basic-addon2">
                                                   <button type="submit" class="btn btn-primary">
                                                       <i class="fa fa-check-circle"></i>
                                                   </button>
                                               </span>
                                               </div>
                                           </form>

                                       </div>
                                   @endif
                               </div>

                               <!--end::Details-->
                           </div>
                           <!--end::Section-->
                           <div class="mb-3">
                               <div class="d-flex flex-stack mb-2 fw-bold fs-3">
                                   <label for="">Toplam</label>
                                   <label>{{formatPrice($total)}} </label>
                               </div>
                           </div>
                       </div>
                       <!--end::Card body-->
                   </div>
                   <!--end::Card-->
               </div>
               <!--end::Sidebar-->
               <div class="col-lg-8">
                   <form class="w-100" method="post" action="{{route('business.packet.pay', $packet->id)}}">
                       @csrf
                       <!--begin::Heading-->
                       <div class="pb-10 pb-lg-15">
                           <!--begin::Title-->
                           <h2 class="fw-bold text-dark">Ödeme Bilgileri</h2>
                           <!--end::Title-->

                           <!--begin::Notice-->
                           <div class="text-muted fw-semibold fs-6">
                               Daha fazla bilgiye ihtiyacınız varsa, lütfen şu adrese göz atın
                               <a href="#" class="text-primary fw-bold">Yardım Merkezi</a>.
                           </div>
                           <!--end::Notice-->
                       </div>
                       <!--end::Heading-->

                       <!--begin::Input group-->
                       <div class="d-flex flex-column mb-7 fv-row">
                           <!--begin::Label-->
                           <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                               <span class="required">Kart Üzerindeki İsim</span>


                               <span class="ms-1" data-bs-toggle="tooltip" title="Kart sahibinin adını belirtin">
	                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                           </label>
                           <!--end::Label-->

                           <input type="text" class="form-control form-control-solid" placeholder="" name="card_name" value="">
                       </div>
                       <!--end::Input group-->

                       <!--begin::Input group-->
                       <div class="d-flex flex-column mb-7 fv-row">
                           <!--begin::Label-->
                           <label class="required fs-6 fw-semibold form-label mb-2">Kart Numarası</label>
                           <!--end::Label-->

                           <!--begin::Input wrapper-->
                           <div class="position-relative">
                               <!--begin::Input-->
                               <input type="text" class="form-control form-control-solid" placeholder="Kart Numaranızı Giriniz" name="card_number" value="">
                               <!--end::Input-->

                               <!--begin::Card logos-->
                               <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                                   <img src="/business/assets/media/svg/card-logos/visa.svg" alt="" class="h-25px">
                                   <img src="/business/assets/media/svg/card-logos/mastercard.svg" alt="" class="h-25px">
                               </div>
                               <!--end::Card logos-->
                           </div>
                           <!--end::Input wrapper-->
                       </div>
                       <!--end::Input group-->

                       <!--begin::Input group-->
                       <div class="row mb-10">
                           <!--begin::Col-->
                           <div class="col-md-8 fv-row">
                               <!--begin::Label-->
                               <label class="required fs-6 fw-semibold form-label mb-2">Son Kullanma Tarihi</label>
                               <!--end::Label-->

                               <!--begin::Row-->
                               <div class="row fv-row">
                                   <!--begin::Col-->
                                   <div class="col-6">
                                       <select name="card_expiry_month" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Ay">
                                           <option></option>
                                           <option value="01">1</option>
                                           <option value="02">2</option>
                                           <option value="03">3</option>
                                           <option value="04">4</option>
                                           <option value="05">5</option>
                                           <option value="06">6</option>
                                           <option value="07">7</option>
                                           <option value="08">8</option>
                                           <option value="09">9</option>
                                           <option value="10">10</option>
                                           <option value="11">11</option>
                                           <option value="12">12</option>
                                       </select>
                                   </div>
                                   <!--end::Col-->

                                   <!--begin::Col-->
                                   <div class="col-6">
                                       <select name="card_expiry_year" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Yıl">
                                           <option></option>
                                           @for($i = now()->year; $i < now()->addYear(10)->year; $i++)
                                               <option value="{{$i}}">{{$i}}</option>
                                           @endfor
                                       </select>
                                   </div>
                                   <!--end::Col-->
                               </div>
                               <!--end::Row-->
                           </div>
                           <!--end::Col-->

                           <!--begin::Col-->
                           <div class="col-md-4 fv-row">
                               <!--begin::Label-->
                               <label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
                                   <span class="required">CVV</span>


                                   <span class="ms-1" data-bs-toggle="tooltip" title="CVV kodu girin">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                               </label>
                               <!--end::Label-->

                               <!--begin::Input wrapper-->
                               <div class="position-relative">
                                   <!--begin::Input-->
                                   <input type="text" class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV" name="card_cvv">
                                   <!--end::Input-->

                                   <!--begin::CVV icon-->
                                   <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                       <i class="ki-duotone ki-credit-cart fs-2hx">
                                           <span class="path1"></span>
                                           <span class="path2"></span>
                                       </i>
                                   </div>
                                   <!--end::CVV icon-->
                               </div>
                               <!--end::Input wrapper-->
                           </div>
                           <!--end::Col-->
                       </div>
                       <!--end::Input group-->

                       <div class="row">
                           <button class="btn btn-primary" type="submit"> Ödeme Yap </button>
                       </div>
                   </form>

               </div>
           </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("[name='card_cvv']").inputmask({
            mask: "9999",
        });
        $("[name='card_number']").inputmask({
            mask: "9999-9999-9999-9999",
        });
    </script>
@endsection
