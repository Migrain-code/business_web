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
            <span class="fw-bold fs-4">Yüklenecek Parapuan {{$appointment->earned_point}} TL</span>
            <div class="fs-7 fw-normal">Eğer müşteriye bu adisyondan parapuan yüklenmesini istiyorsanız.</div>
        </div>
        <div class="col">
            <button type="button" class="btn btn-primary addCashPoint">Parapuan Yükle</button>
        </div>
    </div>
    <!--end::Card body-->
</div>
