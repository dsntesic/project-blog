@if($blogPostsMain->count() > 0)
<div class="row">
    <!-- post -->
    @foreach($blogPostsMain as $blogPost)
    <div class="post col-xl-6">
        <div class="post-thumbnail">
            <a href="{{$blogPost->getSingleBlogPost()}}">
                <img src="{{$blogPost->getPhotoUrl()}}" alt="{{$blogPost->name}}" class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date meta-last">{{$blogPost->getFormatDate()}}</div>
                <div class="category">
                    @include('front._layout.partials.blogPostCategoryName',[
                        'blogPost' => $blogPost
                    ])
                </div>
            </div>
            <a href="{{$blogPost->getSingleBlogPost()}}">
                <h3 class="h4" style="height:50px">{{$blogPost->getStrName()}}</h3>
            </a>
            <p class="text-muted" style="height:100px">{{$blogPost->getStrDescription()}}</p>
            <footer class="post-footer d-flex align-items-center">
                <a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar">
                        <img src="{{optional($blogPost->user)->getPhotoUrl()}}" alt="{{optional($blogPost->user)->name}}" class="img-fluid">
                    </div>
                    <div class="title">
                        <span>{{optional($blogPost->user)->name}}</span>
                    </div>
                </a>
                <div class="date"><i class="icon-clock"></i> {{$blogPost->getFormatHumansDate()}}</div>
                <div class="comments meta-last"><i class="icon-comment"></i>12</div>
            </footer>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-muted">@lang('There is no blog post')</p>
@endif
