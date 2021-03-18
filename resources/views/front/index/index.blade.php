@extends('front._layout.layout')

@section('seo_title',__('Welcome'))

@section('content')
<!-- Hero Section-->
<div id="index-slider" class="owl-carousel">
    @if($latestSliders->count() > 0)
        @foreach($latestSliders as $slider)
        <section style="background: url({{$slider->getPhotoUrl()}}); background-size: cover; background-position: center center" class="hero">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <h1 style="height:100px">{{$slider->name}}</h1>
                        <a href="{{$slider->getButtonUrl()}}" alt='{{$slider->name}}' class="hero-link">{{$slider->button_title}}</a>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
    @endif
</div>

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
<section class="featured-posts no-padding-top">
    <div class="container">
        @if($featuredBlogPosts->count() > 0)
            @foreach($featuredBlogPosts as $blogPost)
            <!-- Post-->
            <div class="row d-flex align-items-stretch">
                @if($loop->iteration %2 != 0)
                    @include('front.index.partials.photoForFeaturedBlogPost',[
                        'blogPost' => $blogPost
                    ])
                @endif
                <div class="text col-lg-7">
                    <div class="text-inner d-flex align-items-center">
                        <div class="content">
                            <header class="post-header">
                                <div class="category">
                                    @include('front.index.partials.blogPostCategoryName',[
                                        'blogPost' => $blogPost
                                    ])
                                </div>
                                <a href="blog-post.html">
                                    <h2 class="h4">{{$blogPost->name}}</h2>
                                </a>
                            </header>
                            <p>{{\Str::limit($blogPost->description,150)}}</p>
                            <footer class="post-footer d-flex align-items-center">
                                <a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar">
                                        <img 
                                            src="{{optional($blogPost->user)->getPhotoUrl()}}" 
                                            alt="{{optional($blogPost->user)->name}}" class="img-fluid"
                                        >
                                    </div>
                                    <div class="title">
                                        <span>{{optional($blogPost->user)->name}}</span>
                                    </div>
                                </a>
                                <div class="date">
                                    <i class="icon-clock"></i>
                                    {{\Carbon\Carbon::parse($blogPost->created_at)->diffForHumans()}}
                                </div>
                                <div class="comments"><i class="icon-comment"></i>12</div>
                            </footer>
                        </div>
                    </div>
                </div>
                @if($loop->iteration %2 == 0)
                    @include('front.index.partials.photoForFeaturedBlogPost',[
                        'blogPost' => $blogPost
                    ])
                @endif
            </div>
            @endforeach
        @endif
    </div>
</section>
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
<section class="latest-posts"> 
    <div class="container">
        <header> 
            <h2>@lang('Latest from the blog')</h2>
            <p class="text-big">@lang('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')</p>
        </header>
        @if($latestBlogPosts->count() > 0)
        <div class="owl-carousel" id="latest-posts-slider">
            <div class="row">
            @foreach($latestBlogPosts as $blogPost)
                <div class="post col-md-4">
                    <div class="post-thumbnail">
                        <a href="blog-post.html">
                            <img src="{{$blogPost->getPhotoUrl()}}" alt="{{$blogPost->name}}" class="img-fluid">
                        </a>
                    </div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">{{\Carbon\Carbon::parse($blogPost->created_at)->format('F d, Y')}}</div>
                            <div class="category">
                                @include('front.index.partials.blogPostCategoryName',[
                                    'blogPost' => $blogPost
                                ])
                            </div>
                        </div>
                        <a href="blog-post.html">
                            <h3 class="h4">{{\Str::limit($blogPost->name,50)}}</h3>
                        </a>
                        <p class="text-muted">{{\Str::limit($blogPost->description,150)}}</p>
                    </div>
                </div>
                @if($loop->iteration == 3 || $loop->iteration == 6 || $loop->iteration == 9)
                </div>
                <div class="row">
                @endif
            @endforeach
            </div>
        </div>  
        @endif
    </div>
</section>
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