
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- SEO SECTION -->
    <!-- Title  -->
    <title>{{config('app.name')}} - @yield('seo_title')</title>
    <meta name="description" content="@yield('seo_description', __('Buy best cloathing, shoes and...'))">

    <!-- OG META-->
    <meta property="og:site_name" content="{{config('app.name')}}">
    <meta property="og:type" content="@yield('seo_og_type', 'website')">
    <meta property="og:title" content="@yield('seo_title', __('Make your blog on the best site in the world'))">
    <meta property="og:description" contet="@yield('seo_description', __('You can write about everything, we are interested in all topics...'))">
    <meta property="og:image" content="@yield('seo_image', url('/themes/front/img/logo.png'))">
    <meta property="og:url" content="{{url()->current()}}">

    <!-- TWITTER META -->

    <meta name="twitter:card" content="{{config('app.name')}}">
    <meta name="twitter:title" content="@yield('seo_title', __('Make your blog on the best site in the world'))">
    <meta name="twitter:description" content="@yield('seo_description', __('You can write about everything, we are interested in all topics...'))">
    <meta name="twitter:image" content="@yield('seo_image', url('/themes/front/img/logo.png'))">

    @yield('head_meta')

    <!-- SEO SECTION-->
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{url('/themes/front/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{url('/themes/front/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Custom icon font-->
    <link rel="stylesheet" href="{{url('/themes/front/css/fontastic.css')}}">
    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <!-- Fancybox-->
    <link rel="stylesheet" href="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{url('/themes/front/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{url('/themes/front/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{url('/themes/front/favicon.png')}}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

    <!-- owl carousel 2 stylesheet-->
    <link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.carousel.min.css')}}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.theme.default.min.css')}}" id="theme-stylesheet">
    @stack('head_css')
</head>