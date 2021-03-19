
<section class="featured-posts no-padding-top">
    <div class="container">
        @if($featuredBlogPosts->count() > 0)
        @foreach($featuredBlogPosts as $blogPost)
        <!-- Post-->
        <div class="row d-flex align-items-stretch">
            @if($loop->iteration %2 == 0)
            @include('front.index.partials.photoForFeaturedBlogPost',[
            'blogPost' => $blogPost
            ])
            @endif
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category">
                                @include('front._layout.partials.blogPostCategoryName',[
                                'blogPost' => $blogPost
                                ])
                            </div>
                            <a href="blog-post.html">
                                <h2 class="h4">{{$blogPost->getStrName()}}</h2>
                            </a>
                        </header>
                        <p>{{$blogPost->getStrDescription()}}</p>
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
                                {{$blogPost->getFormatHumansDate()}}
                            </div>
                            <div class="comments"><i class="icon-comment"></i>12</div>
                        </footer>
                    </div>
                </div>
            </div>
            @if($loop->iteration %2 != 0)
            @include('front.index.partials.photoForFeaturedBlogPost',[
            'blogPost' => $blogPost
            ])
            @endif
        </div>
        @endforeach
        @endif
    </div>
</section>