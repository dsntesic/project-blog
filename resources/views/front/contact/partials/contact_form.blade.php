@push('head_css')
{!! htmlScriptTagJsApi() !!}
@endpush
<form action="{{route('front.contact.send_message')}}" method='post' class="commenting-form" id='contact-form'>
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <input 
                type="text"
                name='contact_person'
                value='{{old('contact_person')}}'
                placeholder="@lang('Your Name')"
                class="form-control @if($errors->has('contact_person'))is-invalid @endif"
            >
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'contact_person'
            ])
        </div>
        <div class="form-group col-md-6">
            <input 
                type="email"
                name='contact_email'
                value='{{old('contact_email')}}'
                placeholder="@lang('Email Address (will not be published)')" 
                class="form-control @if($errors->has('contact_email'))is-invalid @endif"
            >
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'contact_email'
            ])
        </div>
        <div class="form-group col-md-12">
            <textarea 
                name='message'
                placeholder="@lang('Type your message')" 
                class="form-control @if($errors->has('message'))is-invalid @endif"
                rows="10"
            >{{old('message')}}</textarea>
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'message'
            ])
        </div>
        <div class="form-group col-md-12">
            {!! htmlFormSnippet() !!}
            <input class="form-control d-none @if($errors->has('g-recaptcha-response'))is-invalid @endif">
            @include('front._layout.partials.form_errors',[
                'fieldName' => 'g-recaptcha-response'
            ])
        </div>
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-secondary">@lang('Submit Your Message')</button>
        </div>
    </div>
</form>
@push('footer_javascript')
<!-- jQuery Validation -->
<script src="{{url('/themes/front/plugins/jquery-validation/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $('#contact-form').validate({
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        rules: {
            "contact_person": {
                "required": true,
                "rangelength": [2, 50]
            },
            "contact_email": {
                "required": true,
                "email": true,
                "maxlength": 255
            },
            "message": {
                "required": true,
                "rangelength": [50, 500]
            }
        },
        "errorElement": "span",
        errorPlacement: function (error, element) {
            error.appendTo($(element).closest('.form-group').find('.invalid-feedback'));
        }

    });
</script>
@endpush

