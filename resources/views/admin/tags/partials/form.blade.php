
<form action="{{$tag->getActionUrl()}}" method='post' role="form" id='entity-form'>
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('Name')</label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{old('name',$tag->name)}}"
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="@lang('Enter name')"
                    >                
                    @include('admin._layout.partials.form_errors',[
                        'fieldName' => 'name'
                    ])
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">@lang('Save')</button>
        <a href="{{route('admin.tags.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
    </div>
</form>
@push('footer_javascript')
<script type="text/javascript">
$('#entity-form').validate({
    highlight: function (element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function (element) {
        $(element).addClass('is-valid').removeClass('is-invalid');
    },
    rules: {
        "name": {
            "required": true,
            "maxlength": 50
        }
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
        error.appendTo($(element).closest('.form-group').find('.invalid-feedback'));
    }
});
</script>
@endpush