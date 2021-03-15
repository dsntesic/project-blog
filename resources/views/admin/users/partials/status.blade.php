@if($user->isUserActive())
<span class="text-success">@lang('active')</span>
@endif
@if($user->isUserBan())
<span class="text-danger">@lang('ban')</span>
@endif

