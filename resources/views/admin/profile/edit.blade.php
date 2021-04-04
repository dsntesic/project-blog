@extends('admin._layout.layout')

@section('seo_title',__('User Profile'))

@section('title',__('Your Profile'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Profile')</li>
@endsection

@section('content')
<!-- Main content -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Change your profile info')</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.profile.show_change_password')}}" class="btn btn-outline-warning">
                                <i class="fas fa-lock-open"></i>
                                @lang('Change Password')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('admin.profile.update')}}" method='post' role="form" enctype="multipart/form-data" id='entity-form'>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Email')</label>
                                        <div><strong>{{auth()->user()->email}}</strong></div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Name')</label>
                                        <input 
                                            type="text" 
                                            name="name"
                                            value="{{old('name',auth()->user()->name)}}"
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
                                                value="{{old('phone',auth()->user()->phone)}}"
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
                                                    <img width='400' height='600' src="{{auth()->user()->getPhotoUrl()}}" alt="{{auth()->user()->name}}" class="img-fluid" data-container='photo'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                            <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
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
        "url":"{{route('admin.profile.delete_photo')}}",
        "type":"post",
        "data":{
            "_token":"{{csrf_token()}}",
            "id":"{{auth()->user()->id}}"
        }
    })
    .done(function(response){
        toastr.success(response.system_message); 
        $("#entity-form [ data-container='photo']").attr('src',response.profile_photo);
        $("[data-navbar='photo']").attr('src',response.profile_photo);
    })
    .fail(function(){
        toastr.error("@lang('Some error occured while deleting user photo')");
    });
});
</script>
@endpush


