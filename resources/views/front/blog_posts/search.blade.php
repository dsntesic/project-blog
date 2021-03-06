@extends('front._layout.layout')

@section('seo_title',__('All blog posts on our website with key word' . $searchFormTerm['search']))
@section('seo_og_type','article')
@section('seo_description',__('Serious topics for blog posts, interesting topics, get involved'))

@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8">     
            <div class="container"> 
                <h2 class="mb-3">@lang('Search results for') {{$searchFormTerm['search']}}</h2>
                @include('front._layout.partials.latest_blog_posts_main',[
                'blogPostsMain' =>$blogPostsMainSearch
                ])
                <!-- Pagination -->
                {{ $blogPostsMainSearch->appends($searchFormTerm)->links('front._layout.partials.pagination') }}
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
            <!-- Widget [Categories Widget]-->
            @include('front._layout.partials.categories_widget',[
            'frontCategories' =>$frontCategories
            ])
            <!-- Widget [Tags Cloud Widget]-->
            @include('front._layout.partials.tags_widget',[
            'frontTags' =>$frontTags
            ])
        </aside>
    </div>
</div>
@endsection