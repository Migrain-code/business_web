@if(isset($package))
    <div class="col-lg-4">
        <div class="card min-h-400px">
            <div class="card-header p-5 fs-3">
                <ul>
                    @foreach($package->proparties as $propartie)
                        <li> {{$propartie->list->name}}</li>
                    @endforeach
                </ul>
            </div>
            <!--begin::Card header-->
            <div class="card-body">
                <div class="row">
                    <div class="col d-flex flex-stack">
                        <h2>{{$package->name}}</h2>
                        <h2>{{$package->price. "₺"}} / {{$package->type == 0 ? "Aylık": "Yıllık"}}</h2>
                    </div>
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed my-4"></div>
                <!--end::Separator-->
                <div class="row d-flex align-items-center">

                    <div class="col-12 mt-3">
                        @php
                            $totalDay = $package->type == 0 ? 30 : 365;
                            $progressPercentage = ($remainingDay / $totalDay) * 100;
                        @endphp
                        <div class="progress w-100px w-xl-150px w-xxl-300px h-30px bg-gray-300 position-relative">
                            <div class="progress-bar bg-success text-white fs-7 fw-bold" role="progressbar"
                                 style="width: {{$progressPercentage}}%;" aria-valuenow="{{$progressPercentage}}" aria-valuemin="0" aria-valuemax="{{$totalDay}}">
                            </div>
                            <span class="position-absolute fs-7" style="top: 12%;left: 27%">Kalan Gün Sayısı: {{$remainingDay}} Gün</span>

                        </div>
                    </div>
                </div>

                @if($package->id != 1 && $package->id != 6)
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-4"></div>
                    <!--end::Separator-->
                    <div class="row d-flex">
                        <div class="col ">
                            <a class="btn btn-primary w-100 mt-5 freePackageChange" href="javascript:void(0)">Ücretsiz Pakete Geç</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endif
