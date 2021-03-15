@extends('auth._layout.layout')

@section('seo_title',__('Reset password'))

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">@lang('You are only one step a way from your new password, recover your password now').</p>

        <form action="{{ route('password.update') }}" method="post" id='contact-form'>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group mb-3">
                <input 
                    type="email"
                    name='email'
                    value='{{old('email',$email)}}'
                    class="form-control @error('email') is-invalid @enderror" 
                    placeholder="@lang('Email')">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'email'
                ])
            </div>
            <div class="input-group mb-3">
                <input 
                    id="password" 
                    type="password"
                    name='password'
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="@lang('Password')"
                >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'password'
                ])
            </div>
            <div class="input-group mb-3">
                <input 
                    type="password"
                    name='password_confirmation'
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="@lang('Confirm Password')"
                >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'password_confirmation'
                ])
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">@lang('Change password')</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mt-3 mb-1">
            <a href="{{route('login')}}">@lang('Login')</a>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>
@endsection
@push('footer_javascript')

<script type="text/javascript">

$('#contact-form').validate({
    highlight: function (element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function (element) {
        $(element).addClass('is-valid').removeClass('is-invalid');
    },
    rules: {
        "email": {
            "required": true,
            "email": true,
            "maxlength": 255
        },
        "password": {
            "required": true,
            "minlength": 5
        },
        "password_confirmation": {
            "required": true,
            "minlength": 5,
            "equalTo":'#password'
        }
    },
    errorElement: "strong",
    errorPlacement: function (error, element) {
        error.appendTo($(element).closest('.input-group').find('.invalid-feedback'));
    }

});
</script>
@endpush

