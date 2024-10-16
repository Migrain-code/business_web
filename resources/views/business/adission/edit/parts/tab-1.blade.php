
    <div class="d-flex flex-column gap-7 gap-lg-10 mb-5">
        @php
            $adissionPrint = [];
        @endphp
        <!--begin::Product List-->
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header align-items-center">
                <div class="card-title">
                    <h2>Hizmetler</h2>
                </div>
                <div class="d-flex gap-2">
                    @can('adission.add.service')
                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_service">
                        <i class="fa fa-plus-circle"></i>
                        Hizmet Ekle
                    </a>
                    @endcan
                    <a href="{{route('business.adission.printAdission', $appointment->id)}}" target="_blank" class="btn btn-warning">
                        <i class="fa fa-print"></i>
                        Yazdır
                    </a>


                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <form class="table-responsive" method="post" @if(authUser()->hasPermissionTo('adission.update.servicePrice'))  id="sendForm" action="{{route('business.appointment.service.save', $appointment->id)}}" @endif>
                    @csrf
                    @php
                        $calculateTotal = true;

                    @endphp
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                        <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-175px">Personel</th>
                            <th class="min-w-100px text-end">Hizmet</th>
                            <th class="min-w-70px text-end">Süre</th>
                            <th class="min-w-100px text-end">Hizmet Fiyatı</th>
                            @can('adission.add.service')
                                <th class="min-w-100px text-end">İşlemler</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody class="fw-semibold ">
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
                                               class="fw-bold text-hover-primary">{{$service->personel->name}}</a>
                                            <div class="fs-7">İşlem
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
                                @if($service->service->price_type_id == 1 && $service->total == 0)
                                <td class="d-flex flex-column align-items-center justify-content-center">
                                    {{$service->servicePrice()}}
                                    {{$calculateTotal = false}}
                                    <input type="number" class="form-control form-control-solid" placeholder="Net Fiyatını Giriniz" style="max-width: 150px" name="prices[{{$service->id}}]">

                                </td>
                                @else
                                   <td class="text-end">
                                       <input type="number" class="form-control form-control-solid" value="{{$service->servicePrice()}}" placeholder="Net Fiyatını Giriniz" style="max-width: 150px" name="prices[{{$service->id}}]">
                                   </td>
                                @endif
                                @can('adission.add.service')
                                <td class="text-end">
                                    {{create_delete_button('AppointmentServices', $service->id,
                                        'Hizmeti', 'Hizmeti Silmek İstediğinize Emin misiniz?',"true",
                                        route('business.appointment.service.destroy', $service->id)), "true"
                                        }}
                                </td>
                                @endcan
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <!--end::Table-->
                    @can('adission.update.servicePrice')
                        @if(!$calculateTotal)
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Net Fiyatları Kaydet</button>
                            </div>
                        @else
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Fiyatları Güncelle</button>
                            </div>
                        @endif
                    @endcan
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Product List-->
    </div>
    <!--end::Orders-->

