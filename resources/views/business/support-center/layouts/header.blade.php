<!--begin::Hero card-->
<div class="card mb-12">
    <!--begin::Hero body-->
    <div class="card-body flex-column p-5">
        <!--begin::Hero content-->
        <div class="d-flex align-items-center h-lg-300px p-5 p-lg-15">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5">
                <h1 class="fw-bold fs-4 fs-lg-1 text-gray-800 mb-5 mb-lg-10">Destek Merkezi Nedir?</h1>
                <!--end::Title-->

                <!--begin::Input group-->
                <p>Destek merkezi, kullanıcıların sistemde karşılaştıkları sorunları çözmelerine ve sistemi daha iyi anlamalarına yardımcı olmak amacıyla oluşturulmuş bir alandır. Sistemde yaşadığınız sorunları çözmek, anlamadığınız alanları anlamak ve işlevleri kullanmak için bilgilendirici dökümanlar, videolar ve kaynaklar içerir.</p>
                <p>Destek merkezimiz, kullanıcıların sistemi daha etkin bir şekilde kullanmalarına yardımcı olmak için tasarlanmıştır. Burada, genellikle karşılaşılan sorunların yanıtlarını bulabilir, adım adım kılavuzları inceleyebilir ve çözüm bulmak için gerekli olan diğer kaynaklara erişebilirsiniz.</p>
                <p>Ayrıca, destek merkezimizden talep oluşturarak doğrudan destek ekibimizle iletişime geçebilir ve sorunlarınızı daha hızlı bir şekilde çözebilirsiniz. Kullanıcılarımızın ihtiyaçlarını karşılamak ve daha iyi bir deneyim sunmak için destek merkezimiz her zaman hizmetinizdedir.</p>
                <!--end::Input group-->

            </div>
            <!--end::Wrapper-->

            <!--begin::Wrapper-->
            <div class="flex-equal d-flex justify-content-center align-items-end ms-5">
                <!--begin::Illustration-->
                <img src="/business/assets/media/illustrations/sketchy-1/20.png" alt="" class="mw-100 mh-125px mh-lg-275px mb-lg-n12">
                <!--end::Illustration-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Hero content-->

        <!--begin::Hero nav-->
        <div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
            <!--begin::Nav-->
            <ul class="nav flex-wrap border-transparent fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary
                    btn-active-color-primary fw-bolder
                    fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1
                    text-uppercase @if(request()->routeIs('business.support-center.index')) active @endif" href="{{route('business.support-center.index')}}">
                        Talepler
                    </a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase
                           @if(request()->routeIs('business.support.tutorials')) active @endif " href="{{route('business.support.tutorials')}}">
                        Öğretici
                    </a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase
                             @if(request()->routeIs('business.support.faq')) active @endif" href="{{route('business.support.faq')}}">

                        Sık Sorulan Sorular
                    </a>
                </li>
                <!--end::Nav item-->

                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase
                           @if(request()->routeIs('business.support.document.*')) active @endif " href="{{route('business.support.document')}}">

                       Dökümanlar
                    </a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
            @if(request()->routeIs('business.support-center.index'))
                <!--begin::Action-->
                <a href="#" data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_ticket"
                   class="btn btn-primary fw-bold fs-8 fs-lg-base">
                    Talep Oluştur
                </a>
                <!--end::Action-->
            @endif

        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
<!--end::Hero card-->
