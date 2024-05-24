<!--begin::Navbar-->
<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6 justify-content-center">
            <!--begin::Image-->
            <div class="d-flex flex-center flex-shrink-0 rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="rounded-circle"  style="width: 150px;height: 150px;object-fit: cover;" src="{{image($personel->image)}}" alt="image">
            </div>
            <!--end::Image-->

            <!--begin::Wrapper-->
            <div class="flex-grow-1 mt-5">
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
                    {{--
                    @include('business.personel.edit.component.dot-menu')
                    --}}
                </div>
                <!--end::Head-->

                <!--begin::Info-->
                <div class="d-flex flex-wrap justify-content-start">
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

                        <!--begin::Stat-->
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <!--begin::Number-->
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-wallet fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="{{$insideBalance}}" data-kt-countup-prefix="₺">{{$insideBalance}}</div>
                            </div>
                            <!--end::Number-->

                            <!--begin::Label-->
                            <div class="fw-semibold fs-6 text-gray-400">İçerideki Bakiye</div>
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
        <div class="scroll-x h-50px overflow-y-hidden">
            <!--begin::Nav-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" style="width: 800px">
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.edit')) active @endif" href="{{route('business.personel.edit', $personel->id)}}">
                        Önizleme
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.show')) active @endif" href="{{route('business.personel.show', $personel->id)}}">
                        Randevular
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.stayOffDays')) active @endif" href="{{route('business.personel.stayOffDays', $personel->id)}}">
                        İzinler
                    </a>
                </li>
                <!--end::Nav item-->
                @can('case.view')
                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.case')) active @endif" href="{{route('business.personel.case', $personel->id)}}">
                            Kasa
                        </a>
                    </li>
                    <!--end::Nav item-->
                @endcan
                @can('cost.view')
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.payments')) active @endif" href="{{route('business.personel.payments', $personel->id)}}">
                        Ödemeler
                    </a>
                </li>
                @endcan
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.services')) active @endif" href="{{route('business.personel.services', $personel->id)}}">
                        Hizmetler
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.notifications')) active @endif" href="{{route('business.personel.notifications', $personel->id)}}">
                        Bildirimler
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if(request()->routeIs('business.personel.setting')) active @endif" href="{{route('business.personel.setting', $personel->id)}}">
                        Ayarlar
                    </a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
        </div>

    </div>
</div>
<!--end::Navbar-->
