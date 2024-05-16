<div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
    <!--begin::General options-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header align-items-center">
            <div class="card-title">
                <h2>Hizmetler</h2>
            </div>
            <button type="button" id="serviceAllSelect" class="btn btn-secondary">
                Tümünü Seç
            </button>
            <!--end::Input group-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            @foreach($services as $service)
                <div class="d-flex flex-stack flex-column flex-md-row">
                    <div class="d-flex border-0 border-secondary p-2 mb-2" data-bs-toggle="tooltip" title="Bu hizmeti eklemek için seçiniz" style="font-size: 15px">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input serviceChecks" @checked(in_array($service->id, $personel->services()->pluck('service_id')->toArray())) name="services[]" type="checkbox"
                                   value="{{$service->id}}">
                        </div>
                        <span>{{$service->subCategory->name}}</span>

                    </div>

                    <div class="my-2">

                        <div class="input-group mb-5">
                            @if($personel->existCustomPrice($service->id))
                                <input type="text" class="form-control mw-125px" id="prices{{$service->id}}" aria-label="Bu hizmet kaç tl olacak" value="{{$personel->existCustomPrice($service->id)->price}}"/>
                            @else
                                @if($service->price_type_id == 1)
                                    <input type="text" class="form-control mw-125px" id="prices{{$service->id}}" aria-label="Bu hizmet kaç tl olacak" value="{{$service->price. " - ". $service->max_price}}"/>
                                @else
                                    <input type="text" class="form-control mw-125px" id="prices{{$service->id}}" aria-label="Bu hizmet kaç tl olacak" value="{{$service->price}}"/>
                                @endif
                            @endif

                            <span class="input-group-text">
                                TL
                                <button type="button" class="btn btn-sm btn-primary me-2 ms-2" onclick="addPersonelCustomPrice('{{$service->id}}')"><i class="fa fa-check-circle"></i></button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deletePersonelCustomPrice('{{$service->id}}')"><i class="fa fa-xmark"></i></button>

                            </span>
                        </div>
                    </div>
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed"></div>
                <!--end::Separator-->
            @endforeach

        </div>
        <!--end::Card header-->
    </div>
    <!--end::General options-->
</div>
