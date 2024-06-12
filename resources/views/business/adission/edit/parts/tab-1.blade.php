<!--begin::Tab pane-->
<div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
    <!--begin::Orders-->
    <div class="d-flex flex-column gap-7 gap-lg-10">

        <!--begin::Product List-->
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Hizmetler</h2>
                </div>
                <div class="d-flex gap-2">
                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_service">
                        <i class="fa fa-plus-circle"></i>
                        Hizmet Ekle
                    </a>
                    <a href="{{route('business.adission.printAdission', $appointment->id)}}" target="_blank" class="btn btn-warning">
                        <i class="fa fa-print"></i>
                        Yazdır
                    </a>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-175px">Personel</th>
                            <th class="min-w-100px text-end">Hizmet</th>
                            <th class="min-w-70px text-end">Süre</th>
                            <th class="min-w-100px text-end">Hizmet Fiyatı</th>
                            <th class="min-w-100px text-end">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        @foreach($appointment->services as $service)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!--begin::Thumbnail-->
                                        <a href="{{route('business.personel.edit', $service->personel_id)}}"
                                           class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                  style="background-image:url('{{image($service->personel->image)}}');"></span>
                                        </a>
                                        <!--end::Thumbnail-->

                                        <!--begin::Title-->
                                        <div class="ms-5">
                                            <a href="{{route('business.personel.edit', $service->personel_id)}}"
                                               class="fw-bold text-gray-600 text-hover-primary">{{$service->personel->name}}</a>
                                            <div class="fs-7 text-muted">İşlem
                                                Saati: {{\Illuminate\Support\Carbon::parse($service->start_time)->format('H:i')}}</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                </td>
                                <td class="text-end">
                                    {{$service->service->subCategory->name}}
                                </td>
                                <td class="text-end">
                                    {{$service->service->time}} .DK
                                </td>
                                <td class="text-end">
                                    {{$service->servicePrice()}}
                                </td>
                                <td class="text-end">
                                    {{create_delete_button('AppointmentServices', $service->id,
                                        'Hizmeti', 'Hizmeti Silmek İstediğinize Emin misiniz?',"true",
                                        route('business.appointment.service.destroy', $service->id)), "true"
                                        }}
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="4" class="text-end">
                                Ara Toplam
                            </td>
                            <td class="text-end">
                                {{formatPrice($appointment->calculateTotal())}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">
                                Kampanya İndirimi ({{$appointment->discount}}%)
                            </td>
                            <td class="text-end">
                                {{formatPrice($appointment->calculateCampaignDiscount())}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="fs-3 text-dark text-end">
                                Genel Toplam
                            </td>
                            <td class="text-dark fs-3 fw-bolder text-end">
                                {{formatPrice($appointment->calculateTotal()-$appointment->calculateCampaignDiscount())}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Product List-->
    </div>
    <!--end::Orders-->
</div>
<!--end::Tab pane-->
