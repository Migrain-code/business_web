<!--begin::Row-->
<div class="card pt-4 mb-6 mb-xl-9 border-0">
    <!--begin::Card header-->
    <div class="card-header border-0 d-flex align-items-center">
        <!--begin::Card title-->
        <div class="" style="display: block;">
            <h2 style="margin-bottom: 10px;margin-top: 5px;">Tahsilatlar</h2>
        </div>
        <div class="d-flex align-items-center">

            <button type="button" data-bs-toggle="modal" onclick="createCollection()"
                    data-bs-target="#kt_modal_add_payment" style="padding: 10px 20px !important;" class="btn btn-primary me-2">
                <i class="ki-duotone ki-exit-up fs-2"><span class="path1"></span><span class="path2"></span></i>
                Tahsilat Ekle
            </button>

        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table wrapper-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="paymentDataTable">
                <thead>
                <tr>
                    <td class="">Tarih</td>
                    <td>Ödeme Tipi</td>
                    <td class="">Tutar</td>
                    <td class="">Sil</td>
                </tr>
                </thead>
                <!--begin::Table body-->
                <tbody class="fs-6 fw-semibold text-gray-600" id="paymentTable">
                @foreach($appointment->payments as $payed)
                    <tr>
                        <td class="">{{$payed->created_at->format('d.m.Y')}}</td>
                        <td class="">{{$payed->type("name")}}</td>
                        <td class="">{{$payed->price}}₺</td>

                        <td>

                            <a class="btn btn-clean btn-sm btn-icon btn-icon-danger btn-active-light-danger ms-auto delete-btn" href="#" data-toggle="popover"
                               data-object-id="{{$payed->id}}"
                               data-route="{{'/isletme/adission/'.$appointment->id.'/payment/'.$payed->id}}"
                               data-model="App\Models\AppointmentCollectionEntry"
                               data-delete-type="1"
                               data-reload="true"
                               data-content="Tahsilat Kaydını Silmek İstediğinize Eminmisiniz?"
                               data-title="Tahilat">
                                <i class="ki-duotone ki-trash fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
    <div class="card-footer">
        <table class="table">
            <tr class="border-bottom border-dashed">
                <td colspan="4">
                   Hizmet ve Ürünler Toplamı
                </td>
                <td class="text-end">
                    {{formatPrice($appointment->totalServiceAndProduct())}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Kampanya İndirimi ({{$appointment->discount}}%)
                </td>
                <td class="text-end">
                    {{formatPrice($appointment->calculateCampaignDiscount())}}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="fs-3 text-dark">
                    Genel Toplam
                </td>
                <td class="text-dark fs-3 fw-bolder text-end">
                    {{formatPrice($appointment->totalServiceAndProduct()-$appointment->calculateCampaignDiscount())}}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="fs-3 text-dark">
                    Kalan Borç
                </td>
                <td class="text-dark fs-3 fw-bolder text-end">
                    {{formatPrice($appointment->remainingTotal())}}
                </td>
            </tr>
        </table>

    </div>
    <!--end::Card body-->
</div>
<!--end::Row-->

<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="fw-bold">Parapuan Yükle</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0 d-flex flex-stack">
        <div class="fw-bold fs-2 col-8">
            <b id="remainingAmount"></b>
            <span class="text-muted fs-4 fw-semibold">Yüklenecek Parapuan {{$appointment->earned_point}} TL</span>
            <div class="fs-7 fw-normal text-muted">Eğer müşteriye bu adisyondan parapuan yüklenmesini istiyorsanız.</div>
        </div>
        <div class="col">
            <button type="button" class="btn btn-primary addCashPoint">Parapuan Yükle</button>
        </div>
    </div>
    <!--end::Card body-->
</div>
