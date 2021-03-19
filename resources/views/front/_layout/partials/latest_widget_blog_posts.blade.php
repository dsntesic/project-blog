
<div class="widget latest-posts">
    <header>
        <h3 class="h6">@lang('Latest Posts')</h3>
    </header>
    <div class="blog-posts">       
    @if($latestBlogPosts->count() > 0)
        @foreach($latestBlogPosts as $blogPost)
        @break($loop->iteration == 4)
        <a href="blog-post.html">
            <div class="item d-flex align-items-center">
                <div class="image">
                    <img src="{{$blogPost->getPhotoThumbUrl()}}" alt="{{$blogPost->name}}" class="img-fluid">
                </div>
                <div class="title"><strong>{{\Str::limit($blogPost->name,50)}}</strong>
                    <div class="d-flex align-items-center">
                        <div class="views"><i class="icon-eye"></i>{{$blogPost->reviews}}</div>
                        <div class="comments"><i class="icon-comment"></i>12</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    @endif
    </div>
</div>