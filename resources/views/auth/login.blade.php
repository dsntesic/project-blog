@extends('auth._layout.layout')

@section('seo_title',__('Log in'))

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">@lang('Sign in to start your session')</p>

        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input 
                    type="email"
                    name='email'
                    value='{{old('email')}}'
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
            <div class="row">
                <!-- /.col -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">@lang('Sign In')</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mb-1 mt-3">
            <a href="{{ route('password.request') }}">@lang('I forgot my password')</a>
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
            required: true,
            email: true,
            maxlength: 255
        },
        "password": {
            required: true,
            minlength: 5
        }
    },
    errorElement: "strong",
    errorPlacement: function (error, element) {
        error.appendTo($(element).closest('.input-group').find('.invalid-feedback'));
    }

});

</script>
@endpush
