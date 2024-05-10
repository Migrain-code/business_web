<!--begin:::Tab pane-->
<div class="tab-pane fade" id="appointment_request_form_question" role="tabpanel">
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <div class="alert alert-warning"> Burada seçilen hizmete göre soru çıkarılsın mı bu durum seçilecektir.
                Örneğin Gelin Başı hizmetini seçtiğinizde hangi soruların çıkmasını istiyorsanız o soruları işaretleyiniz
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Form-->
            <form class="form" action="#" id="kt_ecommerce_customer_profile">
                @foreach($selectedBusinessServices as $businessService)
                    <!--begin::question-->
                    <div class="m-0">
                        <!--begin::Heading-->
                        <div class="d-flex align-items-center collapsible py-3 toggle @if($loop->first) active @else collapsed @endif mb-0" data-bs-toggle="collapse"
                             data-bs-target="#qustion_{{$businessService->id}}">
                            <!--begin::Icon-->
                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Title-->
                            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">
                                {{$businessService->service->subCategory->getName()}}
                            </h4>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->

                        <!--begin::Body-->
                        <div id="qustion_{{$businessService->id}}" class="collapse @if($loop->first) show @endif fs-6 ms-1">
                            @foreach($allQuestions as $question)
                                <!--begin::Text-->
                                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10 @if($question->status == 0) addedServiceBtn @endif">
                                    <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 15px">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input serviceChecks" name="services[]" type="checkbox" value="1">
                                        </div>
                                        <span>{{$question->title}}</span>
                                    </div>
                                    @if($question->status == 0)
                                        <div class="ms-5 activeBox" style="display: none">
                                            <div class="title border-dashed p-2 bg-light-warning">Bu seçtiğiniz soru için ek hizmetler bulunuyor. Seçmek isterseniz kutuları seçili duruma getirin</div>
                                            <div class="bg-gray-300 p-3">
                                                <div class="row">
                                                    <div class="fv-row">
                                                        <!--begin::Label-->
                                                        <label class="required form-label">Hizmet Seçiniz</label>
                                                        <!--end::Label-->

                                                        <!--begin::Select2-->
                                                        <select name="sub_service_id[]" id="city_select_{{$businessService->id}}" multiple aria-label="Hizmet Seçiniz" data-control="select2" data-placeholder="Hizmet Seçiniz..."  class="form-select form-select-solid fw-bold">
                                                            <option></option>
                                                            @foreach($businessService->service->categorys->subCategories as $subCategory)
                                                                <option value="{{$subCategory->id}}" >{{$subCategory->getName()}}</option>
                                                            @endforeach
                                                        </select>
                                                        <!--end::Select2-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!--end::Text-->
                            @endforeach

                        </div>
                        <!--end::Content-->


                        <!--begin::Separator-->
                        <div class="separator separator-dashed"></div>
                        <!--end::Separator-->
                    </div>
                    <!--end::question-->
                @endforeach

                <!--end::Row-->
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_customer_profile_submit" class="btn btn-light-primary">
                        <span class="indicator-label">Kaydet</span>
                        <span class="indicator-progress">Kaydediliyor...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

</div>
<!--end:::Tab pane-->
