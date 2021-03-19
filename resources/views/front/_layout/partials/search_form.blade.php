<form action="{{route('front.blog_posts.search')}}" method='get' class="search-form">
    <div class="form-group">
        <input type="search" name='search' placeholder="@lang('What are you looking for?')">
        <button type="submit" class="submit"><i class="icon-search"></i></button>
    </div>
</form>