<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@lang('Blog Admin') | @yield('seo_title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{url('/themes/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('/themes/admin/dist/css/adminlte.min.css')}}">
        <!-- Toastr -->
        <link href="{{url('/themes/admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
        <!-- Google Font: Source Sans Pro -->
        <link href="{{url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700')}}" rel="stylesheet">
        @stack('head_links')
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>@lang('Blog')</b> @lang('Admin')</a>
            </div>
            <!-- /.login-logo -->
            @yield('content')
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{url('/themes/admin/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{url('/themes/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{url('/themes/admin/dist/js/adminlte.min.js')}}"></script>
        <!-- Toastr -->
        <script src="{{url('/themes/admin/plugins/toastr/toastr.min.js')}}" type="text/javascript"></script>
        <!-- jQuery Validation -->
        <script src="{{url('/themes/admin/plugins/jquery-validation/jquery.validate.min.js')}}" type="text/javascript"></script>
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
    </body>
</html>
