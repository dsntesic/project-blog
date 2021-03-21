@extends('front._layout.layout')

@section('seo_title',$blogPost->name)
@section('seo_og_type','article')
@section('seo_description',$blogPost->description)
@section('seo_image',$blogPost->getPhotoUrl())

@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="post blog-post col-lg-8"> 
            <div class="container">

                <div class="post-single">
                    <div class="post-thumbnail">
                        <img src="{{$blogPost->getPhotoUrl()}}" alt="{{$blogPost->name}}" class="img-fluid">
                    </div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="category">
                                @include('front._layout.partials.blogPostCategoryName',[
                                'blogPost' => $blogPost
                                ])
                            </div>
                        </div>
                        <h1>{{$blogPost->name}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row">
                            <a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar">
                                    <img src="{{optional($blogPost->user)->getPhotoUrl()}}" alt="{{optional($blogPost->user)->name}}" class="img-fluid">
                                </div>
                                <div class="title"><span>{{optional($blogPost->user)->name}}</span></div>
                            </a>
                            <div class="d-flex align-items-center flex-wrap">       
                                <div class="date"><i class="icon-clock"></i> {{$blogPost->getFormatHumansDate()}}</div>
                                <div class="views"><i class="icon-eye"></i> {{$blogPost->reviews}}</div>
                                <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{$blogPost->getCountComments()}}</a></div>
                            </div>
                        </div>
                        <div class="post-body">
                            <p class="lead">{{$blogPost->description}}</p>
                            {!! $blogPost->content !!}
                        </div>
                        @if($blogPost->tags->count() > 0)
                        <div class="post-tags">
                            @foreach($blogPost->tags as $tag)
                            <a href="blog-tag.html" class="tag">#{{$tag->name}}</a>
                            @endforeach
                        </div>
                        @endif
                        <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                            @isset($previousBlogPost)
                            <a href="{{$previousBlogPost->getSingleBlogPost()}}" class="prev-post text-left d-flex align-items-center">
                                <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                                <div class="text">
                                    <strong class="text-primary">@lang('Previous Post') </strong>
                                    <h6>{{$previousBlogPost->name}}</h6>
                                </div>
                            </a>
                            @endisset
                            @isset($nextBlogPost)
                            <a href="{{$nextBlogPost->getSingleBlogPost()}}" class="next-post text-right d-flex align-items-center justify-content-end">
                                <div class="text">
                                    <strong class="text-primary">@lang('Next Post') </strong>
                                    <h6>{{$nextBlogPost->name}}</h6>
                                </div>
                                <div class="icon next">
                                    <i class="fa fa-angle-right">   </i>
                                </div>
                            </a>
                            @endisset
                        </div>
                        <div class="post-comments" id="post-comments">
                        </div>
                        <div class="add-comment">
                            <header>
                                <h3 class="h6">@lang('Leave a reply')</h3>
                            </header>
                            @include('front.blog_posts.partials.comment_form',[
                                'blogPost' => $blogPost
                            ])
                        </div>
                    </div>
                </div>
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
@push('footer_javascript')
<script type="text/javascript">
function refreshCommentsBlogPost(){
    $.ajax({
        "url":"{{route('front.blog_posts.comments',['blogPost' => $blogPost->id])}}",
        "type":"get",
        "data":{}
    })
    .done(function(response){
        $('#post-comments').html(response);
    })
    .fail(function(){
        toastr.error("@lang('Something is wrong with listing comments')");
    });
}

refreshCommentsBlogPost();
</script>
@endpush