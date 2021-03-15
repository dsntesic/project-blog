@extends('auth._layout.layout')

@section('seo_title','Forgot password')

@section('content')

<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">@lang('Change your password').</p>

        <form  action="{{ route('admin.profile.change_password') }}" method="post" id="contact-form">
            @csrf
            <div class="input-group mb-3">
                <input 
                    type="password"
                    name='old_password'
                    class="form-control @error('old_password') is-invalid @enderror" 
                    placeholder="@lang('Old Password')"
                >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock-open"></span>
                    </div>
                </div>
                @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'old_password'
                ])
            </div>
            <div class="input-group mb-3">
                <input 
                    id='new_password'
                    type="password"
                    name='new_password'
                    class="form-control @error('new_password') is-invalid @enderror" 
                    placeholder="@lang('New Password')"
                >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'new_password'
                ])
            </div>
            <div class="input-group mb-3">
                <input 
                    type="password"
                    name='confirm_password'
                    class="form-control @error('confirm_password') is-invalid @enderror" 
                    placeholder="@lang('Confirm new Password')"
                >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'confirm_password'
                ])
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">@lang('Confirm Password Change')</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mt-3 mb-1">
            <a href="{{ route('password.request') }}">@lang('I forgot my password')</a>
        </p>
    </div>
    <!-- /.login-card-body -->
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
            "old_password": {
                "required": true,
                "minlength": 5
            },
            "new_password": {
                "required": true,
                "minlength": 5
            },
            "confirm_password": {
                "required": true,
                "minlength": 5,
                "equalTo":'#new_password'
            }
        },
        errorElement: "strong",
        errorPlacement: function (error, element) {
            error.appendTo($(element).closest('.input-group').find('.invalid-feedback'));
        }

    });
</script>
@endpush