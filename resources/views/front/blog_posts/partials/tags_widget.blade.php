<div class="widget tags">       
    <header>
        <h3 class="h6">@lang('Tags')</h3>
    </header>
    @if($frontTags->count() > 0)
        <ul class="list-inline">
        @foreach($frontTags as $tag)
            <li class="list-inline-item">
                <a href="blog-tag.html" class="tag">#{{$tag->name}}</a>
            </li>
        @endforeach
        </ul>
    @endif
</div>

