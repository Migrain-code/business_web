<!--begin::Step 1-->
<div class="current" data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-15">
            <!--begin::Title-->
            <h2 class="fw-bold d-flex align-items-center text-dark">
                İşletme Türünüzü Seçiniz
                <span class="ms-1" data-bs-toggle="tooltip" title="Billing is issued based on your selected account typ">
	                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
            </h2>
            <!--end::Title-->

            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">
                Hangi tür işletmeye sahipsiniz. Burada seçeceğiniz seçenek aramalarda çıkmanız için önemlidir.
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="fv-row">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Input group-->
                <div class="mb-0 fv-row">
                    <!--begin::Options-->
                    <div class="mb-0">
                        @foreach($businessCategories as $category)
                            <!--begin:Option-->
                            <label class="d-flex flex-stack mb-5 cursor-pointer">
                                <!--begin::Icon-->

                                <!--end::Icon-->
                                <!--begin:Label-->
                                <span class="d-flex align-items-center me-2">
                                        <span class="symbol symbol-50px me-6">
                                            <img src="{{image($category->icon)}}">
                                        </span>
                                        <span class="fw-bold text-gray-800 text-hover-primary fs-5">{{$category->getName()}}</span>
                                </span>

                                <span class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" name="category_id" @checked($category->id == $business->category_id) value="{{$category->id}}">
                                </span>

                            </label>

                        @endforeach

                    </div>
                    <!--end::Options-->
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Step 1-->
