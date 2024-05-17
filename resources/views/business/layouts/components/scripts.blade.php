@include('business.layouts.components.modal.password-update-modal')
<div class="modal fade" id="notification_detail_modal" tabindex="-1" role="dialog">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 id="notificationTitle">Bildirim İçeriği</h2>
                <!--end::Modal title-->

                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <p id="notificationMessage"></p>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<script src="/business/assets/plugins/global/plugins.bundle.js"></script>
<script src="/business/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<script src="/business/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="/business/assets/js/widgets.bundle.js"></script>
<script src="/business/assets/js/custom/widgets.js"></script>
<script>
    var csrf_token = "{{csrf_token()}}";
</script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,//3sn
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>
@if(session('response'))
    <script>
        Toast.fire({
            icon: '{{session('response.status')}}',
            title: '{{session('response.message')}}',

        })
    </script>
@endif
@if($errors->any())
    <script>
        var errors = [];
        @foreach ($errors->all() as $error)
        errors.push("{{ $error }}");
        @endforeach

        Swal.fire({
            title: 'Hata',
            icon: 'error',
            html: errors.join("<br>"),
            confirmButtonText: "Tamam"
        });
    </script>
@endif
<style>
    .swal2-popup.swal2-toast .swal2-title {
        margin: 0.5em 1em;
        padding: 0;
        font-size: 1em;
        text-align: initial;
        color: black !important;
        font-weight: 700 !important;

    }
</style>
<script src="/business/assets/js/custom.js"></script>
<script>
    $('.messageContentButton').on('click', function (){
        let title = $(this).data('title');
        let content = $(this).data('content');
        $('#notificationTitle').text(title);
        $('#notificationMessage').text(content);
        $('#notification_detail_modal').modal('show');
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>
<script>
    $(document).ready(function(){
        $("#validatorPhone").inputmask({
            mask: "9999 999 9999",
        });
    });
</script>
@if(!request()->routeIs('business.setup.*'))
    <script>
        var button = document.querySelector('#kt_share_earn_link_copy_button');
        var input = document.querySelector('#kt_share_earn_link_input');
        var clipboard = new ClipboardJS(button);

        if (clipboard) {
            //  Copy text to clipboard. For more info check the plugin's documentation: https://clipboardjs.com/
            clipboard.on('success', function(e) {
                var buttonCaption = button.innerHTML;
                //Add bgcolor
                input.classList.add('bg-success');
                input.classList.add('text-inverse-success');

                button.innerHTML = 'Kopyalandı!';

                setTimeout(function() {
                    button.innerHTML = buttonCaption;

                    // Remove bgcolor
                    input.classList.remove('bg-success');
                    input.classList.remove('text-inverse-success');
                }, 3000);  // 3seconds

                e.clearSelection();
            });
        }


    </script>
    <script>
       var forbiddenArea = $('.forbiddenArea');
       if(forbiddenArea.length > 0){
           /*Swal.fire({
               title: 'Yetkisiz Erişim',
               icon: 'error',
               html: "Bu alana erişim sağlama için paket yükseltmeniz gerekmektedir.",
               confirmButtonText: "Tamam"
           }).then(function (res){
                if(res.isConfirmed){
                    window.location.href = "{{url()->previous()}}"
                }
           });*/
       }
    </script>
@endif
@yield('scripts')
