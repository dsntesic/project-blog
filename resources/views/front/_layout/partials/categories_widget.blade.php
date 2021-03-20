<div class="widget categories">
    <header>
        <h3 class="h6">@lang('Categories')</h3>
    </header>
    @if($frontCategories->count() > 0)
        @foreach($frontCategories as $category)
            <div class="item d-flex justify-content-between">
                <a href="{{$category->getSingleCategory()}}">{{$category->name}}</a>
                <span>{{$category->blog_posts_count}}</span>
            </div>
        @endforeach
    @endif
</div>