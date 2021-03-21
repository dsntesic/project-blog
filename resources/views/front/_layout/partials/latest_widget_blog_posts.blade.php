
<div class="widget latest-posts">
    <header>
        <h3 class="h6">@lang('Latest Posts')</h3>
    </header>
    <div class="blog-posts">       
    @if($latestBlogPostsWithMaxReviews->count() > 0)
        @foreach($latestBlogPostsWithMaxReviews as $blogPost)
        <a href="{{$blogPost->getSingleBlogPost()}}">
            <div class="item d-flex align-items-center">
                <div class="image">
                    <img src="{{$blogPost->getPhotoThumbUrl()}}" alt="{{$blogPost->name}}" class="img-fluid">
                </div>
                <div class="title"><strong>{{$blogPost->getStrName()}}</strong>
                    <div class="d-flex align-items-center">
                        <div class="views"><i class="icon-eye"></i>{{$blogPost->reviews}}</div>
                        <div class="comments"><i class="icon-comment"></i>{{$blogPost->getCountComments()}}</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    @endif
    </div>
</div>