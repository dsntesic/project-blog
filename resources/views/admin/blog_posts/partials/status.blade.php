@if($blogPost->isBlogPostEnable())
<span class="text-success">@lang('enable')</span>
@endif
@if($blogPost->isBlogPostDisable())
<span class="text-danger">@lang('disable')</span>
@endif

