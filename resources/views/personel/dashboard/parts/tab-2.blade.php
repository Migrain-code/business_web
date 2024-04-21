<div class="row gx-6 gx-xl-9">
    <!--begin::Col-->
    <div class="col-lg-6 mt-9">
        <!--begin::Summary-->
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">Randevu Özeti</h3>

                    <div class="fs-6 fw-semibold text-gray-400">{{$personel->appointments->count()}} Toplam İşlem</div>
                </div>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <a href="#" class="btn btn-light btn-sm">Randevuları Gör</a>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body p-9 pt-5">
                <!--begin::Wrapper-->
                <div class="d-flex flex-wrap">
                    <!--begin::Chart-->
                    <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                        <div class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
                            <span class="fs-2qx fw-bold">{{$personel->appointments->count()}}</span>
                            <span class="fs-6 fw-semibold text-gray-400">Top. Randevu</span>
                        </div>

                        <canvas id="project_overview_chart"></canvas>
                    </div>
                    <!--end::Chart-->

                    <!--begin::Labels-->
                    <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                            <div class="bullet bg-warning me-3"></div>
                            <div class="text-gray-400">Onaylanacak</div>
                            <div class="ms-auto fw-bold text-gray-700">{{$personel->appointments->whereIn('status', [0])->count()}}</div>
                        </div>
                        <!--end::Label-->
                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                            <div class="bullet bg-primary me-3"></div>
                            <div class="text-gray-400">Onaylanmış</div>
                            <div class="ms-auto fw-bold text-gray-700">{{$personel->appointments->whereIn('status', [1])->count()}}</div>
                        </div>
                        <!--end::Label-->

                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                            <div class="bullet bg-success me-3"></div>
                            <div class="text-gray-400">Tamamlanmış</div>
                            <div class="ms-auto fw-bold text-gray-700">{{$personel->appointments->whereIn('status', [2, 5, 6])->count()}}</div>
                        </div>
                        <!--end::Label-->

                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                            <div class="bullet bg-danger me-3"></div>
                            <div class="text-gray-400">İptal Edilmiş</div>
                            <div class="ms-auto fw-bold text-gray-700">{{$personel->appointments->whereIn('status', [3, 4])->count()}}</div>
                        </div>
                        <!--end::Label-->

                        <!--begin::Label-->
                        <div class="d-flex fs-6 fw-semibold align-items-center">
                            <div class="bullet bg-gray-300 me-3"></div>
                            <div class="text-gray-400">Henüz Başlamamış</div>
                            <div class="ms-auto fw-bold text-gray-700">{{$personel->appointments()->whereDate('start_time', '>', now())->count()}}</div>
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Labels-->
                </div>
                <!--end::Wrapper-->


                <!--begin::Notice-->
                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed  p-6">

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1 ">
                        <!--begin::Content-->
                        <div class=" fw-semibold">

                            <div class="fs-6 text-gray-700 ">
                                Randevularınızın durumlarını grafik olarak göreceksiniz. Grafikte neler gösterildiğini
                                <a href="#" class="fw-bold me-1">
                                    detaylı öğrenmek için tıklayınız
                                </a>

                            </div>
                        </div>
                        <!--end::Content-->

                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Summary-->    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-lg-6 mt-9">
        <!--begin::Graph-->
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">Satış Grafiği</h3>

                    <!--begin::Labels-->
                    <div class="fs-6 d-flex text-gray-400 fs-6 fw-semibold">
                        <!--begin::Label-->
                        <div class="d-flex align-items-center me-6">
                                    <span class="menu-bullet d-flex align-items-center me-2">
                                        <span class="bullet bg-success"></span>
                                    </span>
                            Ürün Satışları
                        </div>
                        <!--end::Label-->

                        <!--begin::Label-->
                        <div class="d-flex align-items-center">
                                    <span class="menu-bullet d-flex align-items-center me-2">
                                        <span class="bullet bg-primary"></span>
                                    </span>
                            Paket Satışları
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Labels-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-10 pb-0 px-5">
                <!--begin::Chart-->
                <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div>
                <!--end::Chart-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Graph-->    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-lg-6 mt-9">
        <!--begin::Card-->
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">Bugünkü Randevular</h3>

                    <div class="fs-6 text-gray-400">Bugün {{$appointments->count()}} randevunuz var</div>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body p-9 pt-4">
                <!--begin:: Content-->
                <div id="kt_schedule_day_0" class="tab-pane fade show ">
                    @forelse($appointments as $appointment)
                        <!--begin::Time-->
                        <div class="d-flex flex-stack position-relative mt-8">
                            <!--begin::Bar-->
                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                            <!--end::Bar-->

                            <!--begin::Info-->
                            <div class="fw-semibold ms-5 text-gray-600">
                                <!--begin::Time-->
                                <div class="fs-5">
                                    {{\Illuminate\Support\Carbon::parse($appointment->start_time)->format('H:i'). ' - '. \Illuminate\Support\Carbon::parse($appointment->end_time)->format('H:i')}}
                                    <span class="fs-7 text-gray-400 text-uppercase"> {{\Illuminate\Support\Carbon::parse($appointment->start_time)->diffForHumans()}}</span>
                                </div>
                                <!--end::Time-->

                                <!--begin::Title-->
                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">
                                    {{$appointment->service->subCategory->name}}
                                </a>
                                <!--end::Title-->

                                <!--begin::User-->
                                <div class="text-gray-400">
                                    Müşteri: <a href="#">{{$appointment->appointment->customer->name}}</a>
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Action-->
                            <a href="{{route('personel.appointment.detail', $appointment->appointment_id)}}" class="btn btn-bg-light btn-active-color-primary btn-sm">Detay</a>
                            <!--end::Action-->
                        </div>
                        <!--end::Time-->
                    @empty
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1 justify-content-center">
                                <!--begin::Content-->
                                <div class=" fw-semibold">
                                    <div class="fs-6 text-white fw-bold">
                                        Bugün için randevu kaydı bulunamadı
                                    </div>
                                </div>
                                <!--end::Content-->

                            </div>
                            <!--end::Wrapper-->
                        </div>
                    @endforelse


                </div>
                <!--end:: Content-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-lg-6 mt-9">

        <!--begin::Tasks-->
        <div class="card card-flush h-lg-100">
            <!--begin::Card header-->
            <div class="card-header mt-6">
                <!--begin::Card title-->
                <div class="card-title flex-column">
                    <h3 class="fw-bold mb-1">Bugün Yapılan İşlemler</h3>

                    <div class="fs-6 text-gray-400">Bugün {{$packageSales->count() + $productSales->count()}} işlem yapıldı</div>
                </div>
                <!--end::Card title-->

                {{--
                    <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View All</a>
                </div>
                <!--end::Card toolbar-->
                --}}
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body d-flex flex-column mb-9 p-9 pt-3">
                @foreach($productSales as $productSale)
                    <!--begin::Item-->
                    <div class="d-flex align-items-center position-relative mb-7">
                        <!--begin::Label-->
                        <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                        <!--end::Label-->

                        <!--begin::Details-->
                        <div class="fw-semibold ms-6">
                            <a href="{{route('business.sale.edit', $productSale->id)}}" class="fs-6 fw-bold text-gray-900 text-hover-primary">
                                {{$productSale->customer->name}} Müşterisine {{$productSale->piece}} Ürün Satışı Yaptı
                            </a>

                            <!--begin::Info-->
                            <div class="text-gray-400">
                                {{$productSale->created_at->diffForHumans()}}
                                <a href="{{route('business.customer.edit', $productSale->customer_id)}}">{{$productSale->customer->name}}</a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->

                        <!--begin::Menu-->
                        <a href="{{route('business.sale.edit', $productSale->id)}}" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto">
                            <i class="ki-duotone ki-eye fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </a>
                    </div>
                    <!--end::Item-->
                @endforeach
                @foreach($packageSales as $packageSale)
                    <!--begin::Item-->
                    <div class="d-flex align-items-center position-relative mb-7">
                        <!--begin::Label-->
                        <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                        <!--end::Label-->

                        <!--begin::Details-->
                        <div class="fw-semibold ms-6">
                            <a href="{{route('business.package-sale.edit', $packageSale->id)}}" class="fs-6 fw-bold text-gray-900 text-hover-primary">
                                {{$productSale->customer->name}} Müşterisine Paket Satışı Yaptı
                            </a>

                            <!--begin::Info-->
                            <div class="text-gray-400">
                                {{$packageSale->created_at->diffForHumans()}}
                                <a href="{{route('business.customer.edit', $packageSale->customer_id)}}">{{$packageSale->customer->name}}</a>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->

                        <!--begin::Menu-->
                        <a href="{{route('business.package-sale.edit', $packageSale->id)}}" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto">
                            <i class="ki-duotone ki-eye fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </a>
                    </div>
                    <!--end::Item-->
                @endforeach
                <!--begin::Item-->
                @if($packageSales->count() + $productSales->count() == 0)
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">

                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1 justify-content-center">
                            <!--begin::Content-->
                            <div class=" fw-semibold">
                                <div class="fs-6 text-white fw-bold">
                                    Bugün için işlem kaydı bulunamadı
                                </div>
                            </div>
                            <!--end::Content-->

                        </div>
                        <!--end::Wrapper-->
                    </div>
                @endif
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Tasks-->
    </div>
    <!--end::Col-->
</div>
