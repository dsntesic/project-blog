
<form 
    action="{{$slider->getActionUrl()}}"
    method='post' 
    role="form" 
    id='entity-form'    
    enctype="multipart/form-data"
    >
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('Name')</label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{old('name',$slider->name)}}"
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="@lang('Enter name')"
                        >                
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'name'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Button Url')</label>
                    <input 
                        type='text'
                        name='button_url'
                        value="{{old('button_url',$slider->button_url)}}"
                        class="form-control @error('button_url') is-invalid @enderror" 
                        placeholder="@lang('Enter button url')"
                        >
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'button_url'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Button Title')</label>
                    <input 
                        type='text'
                        name='button_title'
                        value="{{old('button_title',$slider->button_title)}}"
                        class="form-control @error('button_title') is-invalid @enderror" 
                        placeholder="@lang('Enter button title')"
                        >
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'button_title'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Choose New Photo')</label>
                    <input type="file" name='photo' class="form-control @error('photo') is-invalid @enderror">
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'photo'
                    ])
                </div>
            </div>
            <div class="offset-md-3 col-md-3">
                @if($slider->exists)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('Photo')</label>
                            <div class="text-center">
                                <img src="{{$slider->getPhotoUrl()}}" alt="{{$slider->name}}" class="img-fluid" data-container='photo'>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('Save')</button>
        <a href="{{route('admin.sliders.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
    </div>
</form>
@push('footer_javascript')
<script type="text/javascript">
    jQuery.validator.addMethod('testUrl', function (value, element) {
        return this.optional(element) || /url/.test(value) || /\//.test(value);
    }
    , 'Invalid url.Url must be url tupe or start with /'
            );
    $('#entity-form').validate({
        "highlight": function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        "unhighlight": function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        },
        "rules": {
            "name": {
                "required": true,
                "maxlength": 50
            },
            "button_url": {
                "required": true,
                "testUrl": true
            },
            "button_title": {
                "required": true,
                "maxlength": 30
            },
            "photo": {
            }
        },
        "errorElement": "span",
        "errorPlacement": function (error, element) {
            error.appendTo($(element).closest('.form-group').find('.invalid-feedback'));
        }
    });
</script>
@endpush