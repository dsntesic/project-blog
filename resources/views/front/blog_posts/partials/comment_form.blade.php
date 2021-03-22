@if(isset($system_message))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>{{$system_message}}</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<form action="{{route('front.comments.store')}}" method='post' class="commenting-form" id='comment-form'>
    @csrf
    <input type='hidden' name='blog_post_id' value='{{$blogPost->id}}'>
    <div class="row">
        <div class="form-group col-md-6">
            <input 
                type="text" 
                name="name" 
                value="@isset($request) {{$request->input('name')}} @endisset"
                id="username" 
                placeholder="@lang('Name')" 
                class="form-control @if($errors->has('name')) is-invalid @endif"
            >
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'name'
            ])
        </div>
        <div class="form-group col-md-6">
            <input 
                type="text" 
                name="email"
                value="@isset($request) {{$request->input('email')}} @endisset"
                id="useremail" 
                placeholder="@lang('Email Address (will not be published)')" 
                class="form-control @if($errors->has('email')) is-invalid @endif"
            >
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'email'
            ])
        </div>
        <div class="form-group col-md-12">
            <textarea 
                name="message" 
                id="usercomment" 
                placeholder="@lang('Type your comment')" 
                class="form-control @if($errors->has('message')) is-invalid @endif"
            >@isset($request) {{$request->input('message')}} @endisset</textarea>
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'message'
            ])
        </div>
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-secondary">@lang('Submit Comment')</button>
        </div>
    </div>
</form>