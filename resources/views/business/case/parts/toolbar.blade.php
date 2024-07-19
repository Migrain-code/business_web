<!--begin::Card toolbar-->
<div class="card-toolbar">

    <!--begin::Toolbar-->
    <div class="d-flex justify-content-around align-items-center w-100" data-kt-customer-table-toolbar="base">
        <!--begin::Filter-->
        <div class="d-flex w-600px">

            <form method="get" action="" id="listTypeForm" class="w-100">
            <!--begin::Select2-->
                <div class="d-flex gap-2">
                    @if(request()->routeIs('business.prim'))
                        <select id="personelId" class="form-select form-select-solid" data-control="select2"
                                data-hide-search="true" data-placeholder="Personel Seçiniz"
                                name="personel_id">
                            <option></option>
                            @foreach($personels as $row)
                                <option value="{{$row->id}}" @selected($row->id == $personel->id)>{{$row->name}}</option>
                            @endforeach
                        </select>
                    @endif
                    <input class="form-control form-control-solid" value="{{request()->date_range}}" name="date_range" placeholder="Pick date rage" id="kt_daterangepicker_4"/>

                </div>
            <!--end::Select2-->
            </form>
        </div>
    </div>
    <!--end::Toolbar-->


</div>
<!--end::Card toolbar-->
