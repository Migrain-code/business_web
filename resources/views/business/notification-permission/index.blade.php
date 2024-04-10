@extends('business.layouts.master')
@section('title', 'Bildirim İzinleri')
@section('styles')
@endsection
@section('breadcrumbs')
    <!--begin::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-gray-600 fw-bold lh-1">
        <a href="{{route('business.notification-permission.index')}}"> Bildirim İzinleri </a>
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
                            <span class="card-label fw-bold text-dark">Bildirim İzin Ayarları</span>

                            <span class="text-muted mt-1 fw-semibold fs-7">Burada yapacağınız ayarlar bildirim gönderimlerinde ayarlanacak</span>
                        </h3>

                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <span class="fw-bold" style="font-size: 1.275rem"></span>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body pt-5">

                        <!--begin::Item-->
                        <div class="d-flex flex-stack">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-40px me-5">
                                <i class="ki-duotone ki-notification-bing fs-3x text-primary mb-2">
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
                                        Anlık Bildirimler
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Mobil Uygulamadan anlık bildirimleri alın</span>
                                </div>
                                <!--end:Author-->

                                <!--begin:Action-->

                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-50px notificationSwitch" data-column="is_notification" @checked($permissions->is_notification == 1)  type="checkbox" id="flexSwitchDefault"/>
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
                                <i class="ki-duotone ki-sms fs-3x text-primary mb-2">
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
                                        E-posta
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Özel teklifler ve güncellemeler için e-posta bildirimleri alın</span>
                                </div>
                                <!--end:Author-->

                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-50px notificationSwitch" data-column="is_email" @checked($permissions->is_email == 1)  type="checkbox" id="flexSwitchDefault"/>
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
                                <i class="ki-duotone ki-messages fs-3x text-primary mb-2">
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
                                        Sms
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Randevu Hatırlatmaları ve Teklifler için Sms alın</span>
                                </div>
                                <!--end:Author-->

                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-50px notificationSwitch" data-column="is_sms" @checked($permissions->is_sms == 1)  type="checkbox" id="flexSwitchDefault"/>
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
                                <i class="ki-duotone ki-phone fs-3x text-primary mb-2">
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
                                        Telefon Görüşmeleri
                                    </a>

                                    <span class="text-muted fw-semibold d-block fs-7">Önemli bilgilendirmeler için doğrudan aramaları kabul edin</span>
                                </div>
                                <!--end:Author-->

                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input w-50px notificationSwitch" data-column="is_phone" @checked($permissions->is_phone == 1)  type="checkbox" id="flexSwitchDefault"/>
                                </div>
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->

                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Social widget 1-->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(".notificationSwitch").on('change', function (){
            let column = $(this).data('column');

            $.ajax({
                url: '/isletme/notification-permission',
                type: "POST",
                data: {
                  '_token' : csrf_token,
                  'column': column,
                },
                dataType: "JSON",
                success: function (res) {
                    Swal.fire({
                        text: res.message,
                        icon: res.status,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam, devam et!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                },
                error: function (xhr) {
                    var errorMessage = "<ul>";
                    xhr.responseJSON.errors.forEach(function (error) {
                        errorMessage += "<li>" + error + "</li>";
                    });
                    errorMessage += "</ul>";

                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        html: errorMessage,
                        buttonsStyling: false,
                        confirmButtonText: "Tamam",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        })
    </script>
@endsection
