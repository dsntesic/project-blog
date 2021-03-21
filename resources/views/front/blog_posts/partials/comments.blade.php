
<header>
    <h3 class="h6">@lang('Post Comments')<span class="no-of-comments">({{$commentsBlogPost->count()}})</span></h3>
</header>
@if($commentsBlogPost->count() > 0)
@foreach($commentsBlogPost as $comment)
<div class="comment">
    <div class="comment-header d-flex justify-content-between">
        <div class="user d-flex align-items-center">
            <div class="image">
                <img 
                    src="{{url('/themes/front/img/user.svg')}}" 
                    alt="{{$comment->name}}" 
                    class="img-fluid rounded-circle"
                >
            </div>
            <div class="title">
                <strong>{{$comment->name}}</strong>
                <span class="date">{{$comment->getFormatDate()}}</span>
            </div>
        </div>
    </div>
    <div class="comment-body">
        <p>{{$comment->message}}</p>
    </div>
</div>
@endforeach
@endif