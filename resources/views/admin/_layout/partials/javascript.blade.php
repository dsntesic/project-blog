
<!-- jQuery -->
<script src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('/themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/themes/admin/dist/js/adminlte.min.js')}}"></script>
<!-- Select 2 --> 
<script src="{{url('/themes/admin/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<!-- Toastr -->
<script src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
<!-- jQuery Validation -->
<script src="{{url('/themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}" type="text/javascript"></script>
<!-- Datatables -->
<script src="{{url('/themes/admin/plugins/datatables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    let systemMessage = "{{session()->pull('system_message')}}";
    let systemMessageDanger = "{{session()->pull('system_message_danger')}}";
    if (systemMessage !== "") {
        toastr.success(systemMessage);
    }
    if (systemMessageDanger !== "") {
        toastr.error(systemMessageDanger);
    }
</script>
@stack('footer_javascript')