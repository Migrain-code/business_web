@foreach($category->faqs as $faq)
    <!--begin::question-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse"
             data-bs-target="#qustion_{{$category->id."_".$faq->id}}">
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
                {{$faq->getQuestion()}}
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->

        <!--begin::Body-->
        <div id="qustion_{{$category->id."_".$faq->id}}" class="collapse fs-6 ms-1">
            <!--begin::Text-->
            <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                {{$faq->getAnswer()}}
            </div>
            <!--end::Text-->
        </div>
        <!--end::Content-->


        <!--begin::Separator-->
        <div class="separator separator-dashed"></div>
        <!--end::Separator-->
    </div>
    <!--end::question-->
@endforeach
