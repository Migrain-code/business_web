<!--begin::Step 1-->
<div class="flex-column current" data-kt-stepper-element="content" id="tabMenus">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_woman">Kadın</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_man">Erkek</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_unisex">Unisex</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_woman" role="tabpanel">
            <!--begin::Accordion-->
            @foreach($womanServices as $service)
                <div class="accordion accordion-icon-collapse" id="kt_accordion_service_woman_{{$service["id"]}}">
                    <!--begin::Item-->
                    <div class="mb-5">
                        <!--begin::Header-->
                        <div class="accordion-header py-3 d-flex @if($loop->index > 0) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#kt_accordion_service_woman_item_{{$loop->index}}">
                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                            <h3 class="fw-semibold mb-0 ms-4">{{$service["name"]}}</h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div id="kt_accordion_service_woman_item_{{$loop->index}}" class="fs-6 collapse @if($loop->index == 0) show @endif ps-10" data-bs-parent="#kt_accordion_service_woman_{{$service["id"]}}">
                            @foreach($service["services"] as $subService)
                                <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 14px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input serviceChecks w-25px h-25px" name="services[]" type="checkbox" value="{{$subService["id"]}}">
                                    </div>
                                    <span>{{$subService["name"]}}</span>
                                </div>
                            @endforeach
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Item-->

                </div>
            @endforeach

            <!--end::Accordion-->
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_man" role="tabpanel">
            @foreach($manServices as $service)
                <div class="accordion accordion-icon-collapse" id="kt_accordion_service_man_{{$service["id"]}}">
                    <!--begin::Item-->
                    <div class="mb-5">
                        <!--begin::Header-->
                        <div class="accordion-header py-3 d-flex @if($loop->index > 0) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#kt_accordion_service_man_item_{{$loop->index}}">
                            <span class="accordion-icon">
                                <i class="ki-duotone ki-plus-square fs-1 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </span>
                            <h3 class="fw-semibold mb-0 ms-4">{{$service["name"]}}</h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div id="kt_accordion_service_man_item_{{$loop->index}}" class="fs-6 collapse @if($loop->index == 0) show @endif ps-10" data-bs-parent="#kt_accordion_service_man_{{$service["id"]}}">
                            @foreach($service["services"] as $subService)
                                <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 14px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input serviceChecks w-25px h-25px" name="services[]" type="checkbox" value="{{$subService["id"]}}">
                                    </div>
                                    <span>{{$subService["name"]}}</span>
                                </div>
                            @endforeach
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Item-->

                </div>
            @endforeach
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_unisex" role="tabpanel">
            @foreach($unisexServices as $service)
                <div class="accordion accordion-icon-collapse" id="kt_accordion_service_man_{{$service["id"]}}">
                    <!--begin::Item-->
                    <div class="mb-5">
                        <!--begin::Header-->
                        <div class="accordion-header py-3 d-flex @if($loop->index > 0) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#kt_accordion_service_man_item_{{$loop->index}}">
                            <span class="accordion-icon">
                                <i class="ki-duotone ki-plus-square fs-1 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </span>
                            <h3 class="fw-semibold mb-0 ms-4">{{$service["name"]}}</h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div id="kt_accordion_service_man_item_{{$loop->index}}" class="fs-6 collapse @if($loop->index == 0) show @endif ps-10" data-bs-parent="#kt_accordion_service_man_{{$service["id"]}}">
                            @foreach($service["services"] as $subService)
                                <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 14px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input serviceChecks w-25px h-25px" name="services[]" type="checkbox" value="{{$subService["id"]}}">
                                    </div>
                                    <span>{{$subService["name"]}}</span>
                                </div>
                            @endforeach
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Item-->

                </div>
            @endforeach
        </div>
    </div>
</div>
<!--begin::Step 1-->
