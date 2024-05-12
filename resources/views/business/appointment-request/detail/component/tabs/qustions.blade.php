<!--begin:::Tab pane-->
<div class="tab-pane fade" id="appointment_request_form" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Form Bilgileri</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Adı Soyadı
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="İletişime Geçilecek Kişinin Adı ve Soyadı"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$appointmentRequest->user_name}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Telefon
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Kişinin Telefon Numarası"></i>
                    </label>
                    <!--end::Label-->
                    @php
                     $phone = clearPhone($appointmentRequest->phone);
                     if ($appointmentRequest->contact_type == 2){
                         $phone = maskPhone($phone);
                     }
                    @endphp
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$phone}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">E-posta
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Kişinin E-posta Adresi"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$appointmentRequest->email}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Hizmet
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hangi Hizmeti Almak İstiyor"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$appointmentRequest->service_name}}" />
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Ne Zaman
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Hizmeti Hangi Zaman veya Aralığında Almak İstiyor"></i>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name"
                           value="{{$appointmentRequest->goal_time_type == 1 ? "Belirli bir tarihte": ($appointmentRequest->goal_time_type == 2 ? "Belirli bir süre içerisinde" : "Tarih belli değil")}}" />
                    <!--end::Input-->
                </div>
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Tarih / Zaman
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$appointmentRequest->goal_time}}" />
                    <!--end::Input-->
                </div>
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">İletişim Tercihi
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Eğer müşteri cevabı sms ile istyior ise güncelle formundan cevabınızı sms ile iletebilirsiniz"></i>

                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="name"
                           value="{{$appointmentRequest->contact_type == 1 ? "Müşteriyi arama iznini verdi. Arayabilirsiniz"
                                    : "Müşteri arama iznini vermedi cevabınızı sms ile istiyor"}}"
                    />
                    <!--end::Input-->
                </div>
                <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">Not
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea type="text" class="form-control form-control-solid" rows="5" placeholder=""
                              name="name" >{{$appointmentRequest->note}}</textarea>
                    <!--end::Input-->
                </div>
                @if(isset($appointmentRequest->questions))
                    <div class="bg-gray-300 p-5 rounded mb-7">
                        <h3 class="title">Ek Sorular</h3>

                        @foreach($appointmentRequest->questions as $key => $question)
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-semibold mb-2">{{$key}}
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$question}}" />
                                <!--end::Input-->
                            </div>
                        @endforeach
                    </div>
                @endif
                @if(isset($appointmentRequest->added_services))
                    <div class="bg-gray-300 p-5 rounded mb-7">
                        <h3 class="title">Ek Hizmetler</h3>

                        <div class="d-flex">
                            @foreach($appointmentRequest->added_services as $service)
                                <div class="d-flex">
                                    <div class="form-check mx-3 bg-white rounded" style="">
                                        <input class="form-check-input my-3" type="checkbox" checked="" disabled value="" id="flexCheckDefault" style="margin-left: -20px;">
                                        <label class="form-check-label m-3" for="flexCheckDefault">
                                            {{$service}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</div>
<!--end:::Tab pane-->
