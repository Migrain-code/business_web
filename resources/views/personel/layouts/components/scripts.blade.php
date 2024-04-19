
@include('personel.layouts.components.modal.password-update-modal')

<script>
    var hostUrl = "{{asset('/')}}";
</script>

<script src="/business/assets/plugins/global/plugins.bundle.js"></script>
<script src="/business/assets/js/scripts.bundle.js"></script>
<script src="/business/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="/business/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/business/assets/js/widgets.bundle.js"></script>
<script src="/business/assets/js/custom/widgets.js"></script>
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
@yield('scripts')
