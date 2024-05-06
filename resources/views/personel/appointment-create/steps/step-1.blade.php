<!--begin::Step 1-->

<div class="flex-column current" data-kt-stepper-element="content" id="tabMenus">
    @if($rooms->count() > 0)

            <div data-kt-buttons="true" class="row">
                <div class="col-lg-4 col-12">
                    <!--begin::Salon Default-->
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5" style="min-width: 200px">
                        <!--end::Description-->
                        <div class="d-flex align-items-center me-2">
                            <!--begin::Radio-->
                            <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                <input class="form-check-input" type="radio" checked name="room_id" value=""/>
                            </div>
                            <!--end::Radio-->

                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                    Salon
                                </h2>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Description-->
                    </label>
                    <!--end::Radio button-->
                </div>
                @foreach($rooms as $room)
                    <div class="col-lg-4 col-12">
                        <!--begin::Radio button-->
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5" style="min-width: 200px">
                            <!--end::Description-->
                            <div class="d-flex align-items-center me-2">
                                <!--begin::Radio-->
                                <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                    <input class="form-check-input" type="radio" @checked($room->is_main == 1) name="room_id" value="{{$room->id}}"/>
                                </div>
                                <!--end::Radio-->

                                <!--begin::Info-->
                                <div class="flex-grow-1">
                                    <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                        {{$room->name}}
                                    </h2>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::Description-->
                        </label>
                        <!--end::Radio button-->
                    </div>
                @endforeach
            </div>
            <!--end::Radio group-->
    @else
        <input type="hidden" name="room_id" value="">
    @endif
    <div class="col-8">
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
            @if($business->type_id == 1)
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_woman">Kadın</a>
                </li>
            @endif
            @if($business->type_id == 2)
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_man">Erkek</a>
                    </li>
            @endif
            @if($business->type_id == 3)
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_woman">Kadın</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_man">Erkek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_unisex">Unisex</a>
                    </li>
            @endif


        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade @if($business->type_id == 1 || $business->type_id == 3) show active @endif" id="kt_tab_pane_woman" role="tabpanel">
                <!--begin::Accordion-->
                @foreach($womanServices as $service)
                    <div class="accordion accordion-icon-collapse" id="kt_accordion_service_woman_{{$service["id"]}}">
                        <!--begin::Item-->
                        <div class="mb-5">
                            <!--begin::Header-->
                            <div class="accordion-header py-3 d-flex @if($loop->index > 0) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#kt_accordion_service_woman_item_{{$loop->index}}">
                            <span class="accordion-icon">
                                <i class="ki-duotone ki-plus-square fs-1 accordion-icon-off"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </span>
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
                                        <span>{{$subService["name"] ." - ". formatPrice($subService["price"])}}</span>
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
            <div class="tab-pane fade @if($business->type_id == 2) show active @endif" id="kt_tab_pane_man" role="tabpanel">
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
                                        <span>{{$subService["name"] ." - ". formatPrice($subService["price"])}}</span>

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
                                        <span>{{$subService["name"] ." - ". formatPrice($subService["price"])}}</span>

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
</div>
<!--begin::Step 1-->
