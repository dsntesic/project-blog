@extends('front._layout.layout')

@section('seo_title',__('Contact us if you have any questions'))
@section('seo_description',__('Contact us if you have any questions'))

@section('content')
<!-- Hero Section -->
<section style="background: url({{url('/themes/front/img/hero.jpg')}}); background-size: cover; background-position: center center" class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>@lang("Have an interesting news or idea? Don't hesitate to contact us!")</h1>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="col-lg-8"> 
            <div class="container">
            @include('front.contact.partials.contact_form')
            </div>
        </main>
        <aside class="col-lg-4">
            <!-- Widget [Contact Widget]-->
            @include('front.contact.partials.contact_widget')
            <!-- Widget [Latest Post Widget]-->
            @include('front._layout.partials.latest_widget_blog_posts',[
                'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews
            ])
        </aside>
    </div>
</div>
@endsection