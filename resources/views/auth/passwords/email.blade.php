@extends('auth._layout.layout')

@section('seo_title','Forgot password')

@section('content')

<div class="card-body login-card-body">
    
    <p class="login-box-msg">@lang('You forgot your password? Here you can easily retrieve a new password.')</p>
    <form action="{{ route('password.email') }}" method="post" id="contact-form">
        @csrf
        <div class="input-group mb-3">
            <input 
                id="email" 
                type="email"
                placeholder="@lang('Email')"
                class="form-control @error('email') is-invalid @enderror" 
                name="email" 
                value="{{ old('email') }}" 
                autocomplete="email" autofocus
                >
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'email'
                ])
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">@lang('Request new password')</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <p class="mt-3 mb-1">
        <a href="{{route('login')}}">@lang('Login')</a>
    </p>
</div>
<!-- /.login-card-body -->
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
        }
    },
    errorElement: "strong",
    errorPlacement: function (error, element) {
        error.appendTo($(element).closest('.input-group').find('.invalid-feedback'));
    }

});
</script>
@endpush