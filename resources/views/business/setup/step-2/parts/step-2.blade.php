<!--begin::Step 1-->
<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-15">
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">Hizmetler</h2>
            <!--end::Title-->

            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">
                Bu adımdaki işletmenizin hizmetlerini girmeniz gerekmektedir. İşletmenizde hizmet kaydı olmadan arama listesinde görünmez ve randevu alma satış yapma gibi işlemlere erişemezsiniz.
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->

        @foreach($serviceCategories as $serviceCategory)
            <!--begin::question-->
            <div class="m-0">
                <!--begin::Heading-->
                <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse"
                     data-bs-target="#qustion_{{$serviceCategory->id}}">
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
                        {{$serviceCategory->getName()}}
                    </h4>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->

                <!--begin::Body-->
                <div id="qustion_{{$serviceCategory->id}}" class="collapse fs-6 ms-1">
                    <!--begin::Text-->
                    @foreach($serviceCategory->subCategories as $subCategory)
                        <div class="d-flex flex-stack">
                            <div class="text-gray-600 fw-semibold fs-6 ps-10">
                                {{$subCategory->getName()}}
                            </div>
                            <button class="btn btn-icon-info addServiceBtn" type="button" data-service="{{$subCategory->id}}" data-category="{{$serviceCategory->id}}"><i class="fa fa-plus-circle fs-3"></i></button>
                        </div>
                        <!--begin::Separator-->
                        <div class="separator separator-dashed"></div>
                        <!--end::Separator-->
                    @endforeach

                    <!--end::Text-->
                </div>
                <!--end::Content-->


                <!--begin::Separator-->
                <div class="separator separator-dashed"></div>
                <!--end::Separator-->
            </div>
            <!--end::question-->
        @endforeach


    </div>
    <!--end::Wrapper-->

</div>
<!--end::Step 2-->
