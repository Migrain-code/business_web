<div class="modal fade" tabindex="-1" id="kt_modal_password_update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Şifrenizi Güncelleyin</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form action="{{route('business.passwordUpdate')}}" id="passwordUpdateForm" method="post">
                    @csrf
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Yeni Şifre
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yeni Şifreniz"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" class="form-control form-control-solid" placeholder="" name="password" value="" />
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Yeni Şifre Tekrarı
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Yeni Şifreyi Tekrar Giriniz"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" class="form-control form-control-solid" placeholder="" name="password_confirmation" value="" />
                        <!--end::Input-->
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal Et</button>
                <button type="button" class="btn btn-primary" onclick="$('#passwordUpdateForm').submit()">Şifremi Güncelle</button>
            </div>
        </div>
    </div>
</div>
