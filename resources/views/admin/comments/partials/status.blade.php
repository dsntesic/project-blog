@if($comment->isCommentEnable())
<span class="text-success">@lang('enable')</span>
@endif
@if($comment->isCommentDisable())
<span class="text-danger">@lang('disable')</span>
@endif

