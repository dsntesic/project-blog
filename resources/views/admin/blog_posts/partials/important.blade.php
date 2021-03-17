@if($blogPost->isBlogPostImportant())
<span class="text-success">@lang('yes')</span>
@else
<span class="text-danger">@lang('no')</span>
@endif

