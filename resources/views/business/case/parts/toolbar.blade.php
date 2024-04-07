<!--begin::Card toolbar-->
<div class="card-toolbar">
    <!--begin::Toolbar-->
    <div class="d-flex justify-content-end align-items-center w-100" data-kt-customer-table-toolbar="base">
        <!--begin::Filter-->
        <div class="d-flex w-400px">
            <form method="get" action="" id="listTypeForm" class="w-100">
            <!--begin::Select2-->
            <select id="listType" class="form-select form-select-solid" data-control="select2"
                    data-hide-search="true" data-placeholder="Tarih Aralığı Seçiniz"
                    name="listType">
                <option></option>
                <option value="all">Tümü</option>
                <option value="thisDay" @selected(request()->listType == "thisDay")>Bu Gün</option>
                <option value="thisWeek" @selected(request()->listType == "thisWeek")>Bu Hafta</option>
                <option value="thisMonth" @selected(request()->listType == "thisMonth")>Bu Ay</option>
                <option value="thisYear" @selected(request()->listType == "thisYear")>Bu Yıl</option>
            </select>
            <!--end::Select2-->
            </form>
        </div>
    </div>
    <!--end::Toolbar-->


</div>
<!--end::Card toolbar-->
