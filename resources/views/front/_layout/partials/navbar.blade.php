
<nav class="navbar navbar-expand-lg">
    <div class="search-area">
        <div class="search-area-inner d-flex align-items-center justify-content-center">
            <div class="close-btn"><i class="icon-close"></i></div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    @include('front._layout.partials.search_form')
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Navbar Brand -->
        <div class="navbar-header d-flex align-items-center justify-content-between">
            <!-- Navbar Brand --><a href="{{route('front.index.index')}}" class="navbar-brand">{{config('app.name')}}</a>
            <!-- Toggle Button-->
            <button type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarcollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span></span><span></span><span></span></button>
        </div>
        <!-- Navbar Menu -->
        <div id="navbarcollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a 
                        href="{{route('front.index.index')}}" 
                        class="nav-link @if(url()->current() == route('front.index.index')) active @endif"
                    >@lang('Home')</a>
                </li>
                <li class="nav-item">
                    <a 
                        href="{{route('front.blog_posts.index')}}" 
                        class="nav-link 
                            @if(
                            \Route::currentRouteName() == 'front.blog_posts.index' ||
                            \Route::currentRouteName() == 'front.blog_posts.search' ||
                            \Route::currentRouteName() == 'front.blog_posts.single'
                            )
                            ) active @endif"
                    >@lang('Blog')</a>
                </li>
                <li class="nav-item">
                    <a 
                        href="{{route('front.contact.index')}}" 
                        class="nav-link @if(url()->current() == route('front.contact.index')) active @endif"
                    >@lang('Contact')</a>
                </li>
            </ul>
            <div class="navbar-text"><a href="#" class="search-btn"><i class="icon-search-1"></i></a></div>
        </div>
    </div>
</nav>