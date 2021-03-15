
<form action='{{$user->getActionUrl()}}' method='post' role="form" enctype="multipart/form-data" id='entity-form'>
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('Email')</label>
                    <div class="input-group">
                        <input 
                            type="email" 
                            name="email"
                            value="{{old('email',$user->email)}}"
                            class="form-control @error('email') is-invalid @enderror" 
                            placeholder="@lang('Enter email')"
                        >
                        <div class="input-group-append">
                            <span class="input-group-text">
                                @
                            </span>
                        </div>
                        @include('admin._layout.partials.form_errors',[
                            'fieldName' => 'email'
                        ])
                    </div>
                </div>
                <div class="form-group">
                    <label>@lang('Name')</label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{old('name',$user->name)}}"
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="@lang('Enter name')"
                    >                
                    @include('admin._layout.partials.form_errors',[
                        'fieldName' => 'name'
                    ])
                </div>
                <div class="form-group">
                    <label>Phone</label>                    
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="phone"
                            value="{{old('phone',$user->phone)}}"
                            class="form-control @error('phone') is-invalid @enderror" 
                            placeholder="@lang('Enter phone')"
                        >
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-phone"></i>
                            </span>
                        </div>                                       
                        @include('admin._layout.partials.form_errors',[
                            'fieldName' => 'phone'
                        ])    
                    </div>
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
                @if($user->id)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('Photo')</label>

                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-outline-danger" id='delete-photo'>
                                    <i class="fas fa-remove"></i>
                                    @lang('Delete Photo')
                                </button>
                            </div>
                            <div class="text-center">
                                <img src="{{$user->getPhotoUrl()}}" alt="{{$user->name}}" class="img-fluid" data-container='photo'>
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
        <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
    </div>
</form>
@push('footer_javascript')
<script type="text/javascript">
jQuery.validator.addMethod('testPhone', function(value,element) { 
    return this.optional(element) || value.match(/^\+(3816)\d{7,8}$/);
}
, 'Invalid phone number.Phone number must start with +3816'
);
$('#entity-form').validate({
    highlight: function (element) {
        $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function (element) {
        $(element).addClass('is-valid').removeClass('is-invalid');
    },
    rules: {
        "email": {
            "required": true,
            "email": true
        },
        "name": {
            "required": true,
            "maxlength": 50
        },
        "phone": {               
            "required": true,
            "minlength": 12,
            "maxlength": 13,
            "testPhone": true
        },
        "photo": {
        }
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
        error.appendTo($(element).closest('.form-group').find('.invalid-feedback'));
    }

});

$('#entity-form').on('click','#delete-photo',function(e){
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
        "url":"{{route('admin.users.delete_photo')}}",
        "type":"post",
        "data":{
            "_token":"{{csrf_token()}}",
            "id":"{{$user->id}}"
        }
    })
    .done(function(response){
        toastr.success(response.system_message); 
        $("#entity-form [ data-container='photo']").attr('src',response.user_photo);
    })
    .fail(function(){
        toastr.error("@lang('Some error occured while deleting user photo')");
    });
});
</script>
@endpush