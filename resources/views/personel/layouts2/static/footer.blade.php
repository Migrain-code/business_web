</div>
</div>
</div>
</div>

</div>
<!--end::Page-->
</div>
<script>
    var csrf_token = "{{csrf_token()}}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>
<script>
    $(document).ready(function(){
        $("#validatorPhone").inputmask({
            mask: "9999 999 9999",
        });
    });
</script>
<!--end::App-->
@include('personel.layouts.components.scripts')
</body>
<!--end::Body-->
</html>
