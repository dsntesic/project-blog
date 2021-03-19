@extends('front._layout.layout')

@push('head_css')
 <!-- owl carousel 2 stylesheet-->
    <link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.carousel.min.css')}}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.theme.default.min.css')}}" id="theme-stylesheet">
@endpush

@section('content')
<!-- Hero Section-->
@include('front.index.partials.sliders',[
    'latestSliders' => $latestSliders
])
<!-- Intro Section-->
<section class="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="h3">@lang('Some great intro here')</h2>
                <p class="text-big">@lang('Place a nice') <strong>@lang('introduction')</strong> @lang('here') <strong>@lang("to catch reader's attention")</strong>.</p>
            </div>
        </div>
    </div>
</section>
<!-- Featured Section-->
@include('front.index.partials.featuredBlogPosts',[
    'featuredBlogPosts' => $featuredBlogPosts
])
<!-- Divider Section-->
<section style="background: url({{url('/themes/front/img/divider-bg.jpg')}}); background-size: cover; background-position: center bottom" class="divider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua')</h2>
                <a href="contact.html" class="hero-link">@lang('Contact Us')</a>
            </div>
        </div>
    </div>
</section>
<!-- Latest Posts -->
@include('front.index.partials.latestBlogPosts',[
    'latestBlogPosts' => $latestBlogPosts
])
<!-- Gallery Section-->
<section class="gallery no-padding">    
    <div class="row">
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-1.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-1.jpg')}}" alt="gallery image alt 1" class="img-fluid" title="gallery image title 1">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-2.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-2.jpg')}}" alt="gallery image alt 2" class="img-fluid" title="gallery image title 2">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-3.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-3.jpg')}}" alt="gallery image alt 3" class="img-fluid" title="gallery image title 3">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="{{url('/themes/front/img/gallery-4.jpg')}}" data-fancybox="gallery" class="image">
                    <img src="{{url('/themes/front/img/gallery-4.jpg')}}" alt="gallery image alt 4" class="img-fluid" title="gallery image title 4">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
@push('footer_javascript')
<script src="{{url('/themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
<script>
    $("#index-slider").owlCarousel({
        "items": 1,
        "loop": true,
        "autoplay": true,
        "autoplayHoverPause": true
    });

    $("#latest-posts-slider").owlCarousel({
        "items": 1,
        "loop": true,
        "autoplay": true,
        "autoplayHoverPause": true
    });
</script>
@endpush