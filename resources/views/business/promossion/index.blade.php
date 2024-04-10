@extends('business.layouts.master')
@section('title', 'Promosyonlar')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.home')}}"> Promosyonlar </a>
    </li>
    <!--end::Item-->
@endsection
@section('content')
    <div id="kt_app_content" class="app-content">
        <div class="row mx-5">
            <div class="col-12">
                <!--begin::Social widget 1-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Promosyon Ayarları</span>

                            <span class="text-muted mt-1 fw-semibold fs-7">Burada yazacağınız değerler indirim olarak uygulanacak</span>
                        </h3>

                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <span class="fw-bold" style="font-size: 1.275rem"></span>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <form class="card-body pt-5" method="post" action="{{route('business.promossion.store')}}">
                        @csrf
                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-5">
                                <i class="ki-duotone ki-wallet fs-3x text-primary mb-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="javascript:void(0)"
                                       class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                        Parapuan Kazanımı (Nakit)
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Nakit Ödemelerde yüzde kaç parapuan kazanacak</span>
                                </div>
                                <!--end:Author-->

                                <!--begin:Action-->

                                <div class="input-group mb-5 w-150px">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="number" class="form-control" placeholder="Örn. 2" aria-label="Örn. 2" value="{{$promossions->cash}}" name="cash" min="0" max="100" aria-describedby="basic-addon1"/>
                                </div>

                                <!--end:Action-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-5">
                                <i class="ki-duotone ki-credit-cart fs-3x text-primary mb-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>

                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="javascript:void(0)"
                                       class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                        Parapuan Kazanımı (Kredi Kartı)
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">>Kredi Kartı ile Yapılan Ödemelerde yüzde kaç parapuan kazanacak</span>
                                </div>
                                <!--end:Author-->

                                <div class="input-group mb-5 w-150px">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="number" class="form-control" placeholder="Örn. 2" aria-label="Örn. 2" value="{{$promossions->credit_cart}}" name="credit" min="0" max="100" aria-describedby="basic-addon1"/>
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-5">
                                <i class="ki-duotone ki-send fs-3x text-primary mb-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>

                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="javascript:void(0)"
                                       class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                        Parapuan Kazanımı (Eft/Havale)
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Eft/Havale ile Yapılan Ödemelerde yüzde kaç parapuan kazanacak</span>
                                </div>
                                <!--end:Author-->

                                <div class="input-group mb-5 w-150px">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="number" class="form-control" placeholder="Örn. 2" aria-label="Örn. 2" value="{{$promossions->eft}}" name="eft" min="0" max="100" aria-describedby="basic-addon1"/>
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-5">
                                <i class="fa-solid fa-cake-candles fs-3x text-primary mb-2">
                                </i>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="javascript:void(0)"
                                       class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                        Doğum Günü İndirimi
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Müşteriniz randevusunu doğum gününde almışsa bu indirim uygulanır</span>
                                </div>
                                <!--end:Author-->

                                <div class="input-group mb-5 w-150px">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="number" class="form-control" placeholder="Örn. 2" aria-label="Örn. 2" value="{{$promossions->birthday_discount}}" name="birthday" min="0" max="100" aria-describedby="basic-addon1"/>
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-5">
                                <i class="ki-duotone ki-chart-pie-4 fs-3x text-primary mb-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Section-->
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <!--begin:Author-->
                                <div class="flex-grow-1 me-2">
                                    <a href="javascript:void(0)"
                                       class="text-gray-800 text-hover-primary fs-6 fw-bold">
                                        Parapuan Kullanım Limiti
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Parapuanlarını kaç tl'ye kadar kullanabilir</span>
                                </div>
                                <!--end:Author-->

                                <div>
                                    <select name="use_limit" id="city_select" aria-label="Kullanım Limiti Seçiniz"
                                            data-control="select2" data-placeholder="Kullanım Limiti Seçiniz..."
                                            class="form-select form-select-solid fw-bold w-150px">
                                        <option value="">Kullanım Limiti Seçiniz</option>
                                        @for($i = 0; $i <= 100; $i++)
                                            <option value="{{$i}}" @selected($promossions->use_limit == $i)>{{$i. "₺"}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-4"></div>
                        <!--end::Separator-->

                        <!--begin::Item-->
                        <div class="d-flex flex-end">
                            <button type="submit" class="btn btn-primary w-250px">Kaydet</button>
                        </div>
                        <!--end::Item-->
                    </form>
                    <!--end::Body-->
                </div>
                <!--end::Social widget 1-->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

    </script>
@endsection
