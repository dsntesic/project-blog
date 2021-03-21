@extends('front._layout.layout')

@section('seo_title',$user->name)
@section('seo_og_type','article')
@section('seo_image',$user->getPhotoUrl())

@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8">
            <h2 class="mb-3 author d-flex align-items-center flex-wrap">
                <div class="avatar">
                    <img src="{{$user->getPhotoUrl()}}" alt="{{$user->name}}" width="100" height="100" class="ml-3 img-fluid rounded-circle">
                </div>
                <div class="title">
                    <span>@lang('Posts by author') "{{$user->name}}"</span>
                </div>
            </h2>
            <div class="container">
                @include('front._layout.partials.latest_blog_posts_main',[
                    'blogPostsMain' =>$userBlogPosts
                ])
                <!-- Pagination -->
                {{ $userBlogPosts->links('front._layout.partials.pagination') }}
            </div>
        </main>
        <aside class="col-lg-4">
            <!-- Widget [Search Bar Widget]-->
            <div class="widget search">
                <header>
                    <h3 class="h6">@lang('Search the blog')</h3>
                </header>
                @include('front._layout.partials.search_form')
            </div>
            <!-- Widget [Latest Posts Widget] -->
            @include('front._layout.partials.latest_widget_blog_posts',[
                'latestBlogPostsWithMaxReviews' => $latestBlogPostsWithMaxReviews
            ])
            <!-- Widget [Users Widget]-->
            @include('front._layout.partials.categories_widget',[
                'frontCategories' =>$frontCategories
            ])
            <!-- Widget [Users Cloud Widget]-->
            @include('front._layout.partials.tags_widget',[
                'frontTags' =>$frontTags
            ])
        </aside>
    </div>
</div>
@endsection