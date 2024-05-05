<!--begin::Step 1-->
<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">
        <!--begin::Heading-->
        <div class="pb-10 pb-lg-15">
            <!--begin::Title-->
            <h2 class="fw-bold text-dark">Personeller</h2>
            <!--end::Title-->

            <!--begin::Notice-->
            <div class="text-muted fw-semibold fs-6">
                Bu adımdaki işletmenizin personellerini eklemeniz gerekmektedir. İşletmenizde personel kaydı olmadan arama listesinde görünmez ve randevu alma satış yapma gibi işlemlere erişemezsiniz.
            </div>
            <!--end::Notice-->
        </div>
        <!--end::Heading-->
        <div class="d-flex flex-end my-2">
            <button type="button" class="btn btn-light-warning" id="add_personel_btn" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Personel Ekle <i class="fa fa-plus-circle"></i></button>
        </div>
        <div id="personelList">
            @forelse($business->personels as $personel)
                <div class="d-flex align-items-center py-2">
                    <img src="{{image($personel->image)}}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover">
                    <div class="text-gray-600 fw-bold fs-5 ps-4">
                        {{$personel->name}}
                    </div>
                </div>
                <!--begin::Separator-->
                <div class="separator separator-dashed"></div>
                <!--end::Separator-->
            @empty
                @include('business.layouts.components.alerts.empty-alert')
            @endforelse
        </div>


    </div>
    <!--end::Wrapper-->
</div>
<!--end::Step 2-->
