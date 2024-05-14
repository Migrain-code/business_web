@extends('business.layouts.master')
@section('title', 'Ödeme')
@section('styles')

@endsection
@section('content')
    <!--begin::Pricing card-->
    <div class="card" id="kt_pricing">
        <!--begin::Card body-->
        <div class="card-body p-lg-17">
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
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
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
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                    <option value="2032">2032</option>
                                    <option value="2033">2033</option>
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
@endsection

@section('scripts')

@endsection
