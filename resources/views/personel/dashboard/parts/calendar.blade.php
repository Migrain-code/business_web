<div class="col-xxl-12 mb-5 mb-xl-10">
    <div class="card card-flush mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header mt-6 align-items-center">
            <!--begin::Card title-->
            <div class="card-title flex-column">
                <h2 class="mb-1">Randevu Takvimi</h2>

                <div class="fs-6 fw-semibold text-muted">Hangi gündeki randevularınızı görmek istiyorsanız o güne tıklayınız</div>
            </div>
            <!--end::Card title-->
            <div class="d-flex">
                <a class="btn btn-light-primary me-2" href="{{route('personel.appointment.calendar')}}">Takvim Görünümü</a>

                <button class="btn btn-light-warning" id="castButton">Yansıt</button>
            </div>
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body p-9 pt-4">
            <!--begin::Dates-->
            <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2 scrollable-container">
                @foreach($dates as $date)
                    <!--begin::Date-->
                    <li class="nav-item me-1">
                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-40px me-2 py-4 btn-active-primary clickedDate @if($date["value"] == now()->format('Y-m-d')) active @endif"
                           data-bs-toggle="tab" href="#kt_schedule_day" data-date="{{$date["value"]}}">

                            <span class="opacity-50 fs-7 fw-semibold">{{$date["day"]}}</span>
                            <span class="fs-6 fw-bolder">{{$date["date"]}}</span>
                        </a>
                    </li>
                    <!--end::Date-->
                @endforeach

            </ul>
            <!--end::Dates-->

            <!--begin::Tab Content-->
            <div class="tab-content">
                <div class="scroll-y me-n7 pe-7" id="clockContainer" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="200px">
                </div>
            </div>
            <!--end::Tab Content-->
        </div>
        <!--end::Card body-->
    </div>

</div>
