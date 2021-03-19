<!-- JavaScript files-->
<!-- jQuery -->
<script src="{{url('/themes/front/vendor/jquery/jquery.min.js')}}"></script>
<!-- Popper -->
<script src="{{url('/themes/front/vendor/popper.js/umd/popper.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{url('/themes/front/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- Jquery cookie -->
<script src="{{url('/themes/front/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
<!-- Fancybox -->
<script src="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.js')}}"></script>
<!-- Toastr -->
<script src="{{url('/themes/front/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>

<script src="{{url('/themes/front/js/front.js')}}"></script>

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

