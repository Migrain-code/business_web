<!--begin:::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
    <div class="row row-cols-1 row-cols-md-2 mb-6 mb-xl-9">
        <div class="col">
            <!--begin::Card-->
            <div class="card pt-4 h-md-100 mb-6 mb-md-0">
                <!--begin::Card header-->
                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bold">Para Puanları</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="fw-bold fs-2">
                        <div class="d-flex">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen030.svg-->
                            <span class="svg-icon svg-icon-info svg-icon-2x">
																				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																					<path d="M18.3721 4.65439C17.6415 4.23815 16.8052 4 15.9142 4C14.3444 4 12.9339 4.73924 12.003 5.89633C11.0657 4.73913 9.66 4 8.08626 4C7.19611 4 6.35789 4.23746 5.62804 4.65439C4.06148 5.54462 3 7.26056 3 9.24232C3 9.81001 3.08941 10.3491 3.25153 10.8593C4.12155 14.9013 9.69287 20 12.0034 20C14.2502 20 19.875 14.9013 20.7488 10.8593C20.9109 10.3491 21 9.81001 21 9.24232C21.0007 7.26056 19.9383 5.54462 18.3721 4.65439Z" fill="currentColor" />
																				</svg>
																			</span>
                            <!--end::Svg Icon-->
                            <div class="ms-2">4,571
                                <span class="text-muted fs-4 fw-semibold">Puan Kazanıldı</span></div>
                        </div>
                        <div class="fs-7 fw-normal text-muted">Randevu alımında kazanılan parapuanları.</div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <div class="col">
            <!--begin::Reward Tier-->
            <a href="#" class="card bg-info hoverable h-md-100">
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen020.svg-->
                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
																		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																			<path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor" />
																			<path opacity="0.3" d="M20 4H17V3C17 2.4 16.6 2 16 2H8C7.4 2 7 2.4 7 3V4H4C3.4 4 3 4.4 3 5V9C3 11.2 4.8 13 7 13C8.2 14.2 8.8 14.8 10 16H14C15.2 14.8 15.8 14.2 17 13C19.2 13 21 11.2 21 9V5C21 4.4 20.6 4 20 4ZM5 9V6H7V11C5.9 11 5 10.1 5 9ZM19 9C19 10.1 18.1 11 17 11V6H19V9ZM17 21V22H7V21C7 20.4 7.4 20 8 20H16C16.6 20 17 20.4 17 21ZM10 9C9.4 9 9 8.6 9 8V5C9 4.4 9.4 4 10 4C10.6 4 11 4.4 11 5V8C11 8.6 10.6 9 10 9ZM10 13C9.4 13 9 12.6 9 12V11C9 10.4 9.4 10 10 10C10.6 10 11 10.4 11 11V12C11 12.6 10.6 13 10 13Z" fill="currentColor" />
																		</svg>
																	</span>
                    <!--end::Svg Icon-->
                    <div class="text-white fw-bold fs-2 mt-5">Randevu Alındı</div>
                    <div class="fw-semibold text-white">Bugüne Kadar İşletmeden Aldığı Randevu Sayısı: <b>{{$customer->appointments()->where('business_id', authUser()->business_id)->count()}}</b></div>
                </div>
                <!--end::Body-->
            </a>
            <!--end::Reward Tier-->
        </div>
    </div>
    <!--begin::Card-->
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Randevu Geçmişi</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 pb-5">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed gy-5" id="datatable_appointment">
                <!--begin::Table head-->
                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                <!--begin::Table row-->
                <tr class="text-start text-muted text-uppercase gs-0">
                    <th class="min-w-100px">Rand No.</th>
                    <th class="min-w-100px">İşletme</th>
                    <th>Status</th>
                    <th>Fiyat</th>
                    <th class="min-w-100px">Tarih</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fs-6 fw-semibold text-gray-600">
                    @forelse($customer->appointments as $appointment)
                        <tr>
                            <!--begin::order=-->
                            <td>
                                <a href="../sales/details.html" class="text-gray-600 text-hover-primary mb-1">#{{$appointment->id}}</a>
                            </td>
                            <!--end::order=-->
                            <!--begin::Business=-->
                            <td>
                                <a href="../sales/details.html" class="text-gray-600 text-hover-primary mb-1">#{{$appointment->business->name}}</a>
                            </td>
                            <!--end::Business=-->
                            <!--begin::Status=-->
                            <td>
                                {!! $appointment->status("html") !!}
                            </td>
                            <!--end::Status=-->
                            <!--begin::Amount=-->
                            <td>₺{{number_format(calculateTotal($appointment->services), 2)}}</td>
                            <!--end::Amount=-->

                            <!--begin::Date=-->
                            <td>{{\Illuminate\Support\Carbon::parse($appointment->services->first()->start_time)->translatedFormat('d.m.Y, H:i')}}</td>
                            <!--end::Date=-->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                @include('business.layouts.components.alerts.empty-alert')
                            </td>
                        </tr>
                        <!--begin::Alert-->

                        <!--end::Alert-->
                    @endforelse
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end:::Tab pane-->
