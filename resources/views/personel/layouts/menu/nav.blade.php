<!--begin::Navbar-->
<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap justify-content-center mb-6">
            <!--begin::Image-->
            <div class="d-flex flex-center flex-shrink-0 bg-light rounded-circle w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4" id="personelProfileImage">
                <img class="rounded-circle" style="width: 110px;height: 110px;object-fit: contain;" src="{{image($personel->image)}}" alt="image">
            </div>
            <!--end::Image-->

            <!--begin::Wrapper-->
            <div class="flex-grow-1">
                <!--begin::Head-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::Details-->
                    <div class="d-flex flex-column">
                        <!--begin::Status-->
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{$personel->name}}</a>
                            @if($personel->safe == 0)
                                <span class="badge badge-light-warning me-auto">Personel</span>
                            @else
                                <span class="badge badge-light-success me-auto">Kasa</span>
                            @endif
                        </div>
                        <!--end::Status-->

                        <!--begin::Description-->
                        @if($personel->safe == 1)
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                                Bu personele kasa erişim yetkisi verdiniz.
                            </div>
                        @endif

                        <!--end::Description-->
                    </div>
                    <!--end::Details-->

                </div>
                <!--end::Head-->

                <!--begin::Info-->
                <div class="d-flex flex-wrap justify-content-start miniSummaryContent">
                    <!--begin::Stats-->
                    <div class="d-flex flex-wrap">
                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">{{$personel->created_at->translatedFormat('d F, Y')}}</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-400">Kayıt Tarihi</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-calendar fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="{{$personel->appointments->count()}}">0</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-400">Toplam Randevu</div>
                            <!--end::Label-->
                        </div>
                        <!--end::Stat-->


                    </div>
                    <!--end::Stats-->

                </div>
                <!--end::Info-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Details-->

        <div class="separator"></div>

        <div class="p-5">
            <div class="scroll-x">
                <div style="width: 1200px">
                    <div class="row g-5 g-xl-8 ">
                        <div class="col-3">

                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card hoverable card-xl-stretch mb-xl-8 text-white" style="background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <i class="ki-duotone ki-chart-simple text-danger fs-2x ms-n1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>

                                    <div class="fw-bold fs-2 mb-2 mt-5">
                                        {{formatPrice($personel->totalBalance())}}
                                    </div>

                                    <div class="fw-semibold text-gray-400">
                                        Toplam Yapılan Kazanç
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>

                        <div class="col-3">

                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #484286;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <i class="ki-duotone ki-cheque text-gray-100 fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></i>

                                    <div class="text-gray-100 fw-bold fs-2 mb-2 mt-5">
                                        {{$personel->getCustomer()}}
                                    </div>

                                    <div class="fw-semibold text-gray-100">
                                        Müşteriye Hizmet verildi
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>

                        <div class="col-3">

                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card hoverable card-xl-stretch mb-xl-8" style="background-color: #132c3d;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <i class="ki-duotone ki-briefcase text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>

                                    <div class="text-white fw-bold fs-2 mb-2 mt-5">
                                        {{$personel->appointments->count()}}
                                    </div>

                                    <div class="fw-semibold text-white">
                                        İşlemde Hizmet Verdi
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>

                        <div class="col-3">

                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card hoverable card-xl-stretch mb-5 mb-xl-8" style="background-color: #484286;background-image:url('/business/assets/media/svg/shapes/wave-bg-purple.svg')">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <i class="ki-duotone ki-chart-pie-simple text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span></i>

                                    <div class="text-white fw-bold fs-2 mb-2 mt-5">
                                        {{formatPrice($personel->insideBalance())}}
                                    </div>

                                    <div class="fw-semibold text-white">
                                        İçeride Kalan Bakiye
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="separator"></div>
        <div class="scroll-x h-50px overflow-y-hidden">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" style="width: 800px">
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 appointmentTab active" data-bs-toggle="tab" href="#kt_ecommerce_personel_appointment" role="tab">
                    Randevular
                </a>
            </li>
            <!--end::Nav item-->
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6" href="{{route('personel.appointmentCreate.index')}}">
                    Randevu Oluşturma
                </a>
            </li>
            <!--begin::Nav item-->
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6" href="{{route('personel.speedAppointment.index')}}">
                   Saat Kapatma
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#kt_ecommerce_personel_overview" role="tab">
                    Önizleme
                </a>
            </li>
            <!--end::Nav item-->

        </ul>
        </div>
    </div>
</div>
<!--end::Navbar-->
