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
                            <div class="date">{{$blogPost->getFormatDate()}}</div>
                            <div class="category">
                                @include('front._layout.partials.blogPostCategoryName',[
                                    'blogPost' => $blogPost
                                ])
                            </div>
                        </div>
                        <a href="blog-post.html">
                            <h3 class="h4">{{$blogPost->getStrName()}}</h3>
                        </a>
                        <p class="text-muted">{{$blogPost->getStrDescription()}}</p>
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