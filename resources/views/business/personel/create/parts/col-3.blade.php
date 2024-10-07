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
                <div class="d-flex border-0 border-bottom-1 border-dashed border-secondary p-2 mb-2" style="font-size: 15px">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input serviceChecks" @checked(old('services') != null ? in_array($service->id, old('services')) : "") name="services[]" type="checkbox"
                               value="{{$service->id}}">
                    </div>
                    <span>{{$service->subCategory->name}} {{ " (". $service->gender->nam .")" }}</span>
                </div>
            @endforeach

        </div>
        <!--end::Card header-->
    </div>
    <!--end::General options-->
</div>
