
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="logo">
                    <h6 class="text-white">{{config('app.name')}}</h6>
                </div>
                <div class="contact-details">
                    <p>53 Broadway, Broklyn, NY 11249</p>
                    <p>@lang('Phone'): (020) 123 456 789</p>
                    <p>@lang('Email'): <a href="mailto:info@company.com">Info@Company.com</a></p>
                    <ul class="social-menu">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-behance"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="menus d-flex">
                    <ul class="list-unstyled">
                        <li> <a href="{{route('front.index.index')}}">@lang('Home')</a></li>
                        <li> <a href="{{route('front.blog_posts.index')}}">@lang('Blog')</a></li>
                        <li> <a href="{{route('front.contact.index')}}">@lang('Contact')</a></li>
                        <li> <a href="{{route('login')}}">@lang('Login')</a></li>
                    </ul>
                    @if($frontCategories->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($frontCategories as $category)
                            @break($loop->iteration == 5)
                            <li> <a href="">{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                @if($latestBlogPosts->count() > 0)
                <div class="latest-posts">
                    @foreach($latestBlogPosts as $blogPost)
                        @break($loop->iteration == 4)
                        <a href="{{$blogPost->getSingleBlogPost()}}">
                            <div class="post d-flex align-items-center">
                                <div class="image">
                                    <img src="{{$blogPost->getPhotoThumbUrl()}}" alt="{{$blogPost->name}}" class="img-fluid">
                                </div>
                                <div class="title">
                                    <strong>{{$blogPost->getStrName()}}</strong>
                                    <span class="date last-meta">{{$blogPost->getFooterFormatDate()}}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="copyrights">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2017. @lang('All rights reserved. Your great site.')</p>
                </div>
                <div class="col-md-6 text-right">
                    <p>@lang('Template By') <a href="https://bootstrapious.com/p/bootstrap-carousel" class="text-white">@lang('Bootstrapious')</a>
                        <!-- Please do not remove the backlink to Bootstrap Temple unless you purchase an attribution-free license @ Bootstrap Temple or support us at http://bootstrapious.com/donate. It is part of the license conditions. Thanks for understanding :)                         -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>