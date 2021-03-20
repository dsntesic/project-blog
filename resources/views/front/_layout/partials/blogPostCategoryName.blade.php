@if(optional($blogPost->category)->id)
<a href="{{$blogPost->category->getSingleCategory()}}" >{{\Str::limit(optional($blogPost->category)->name,20)}}</a>
@else
<a>@lang('Uncategorized')</a>
@endif

