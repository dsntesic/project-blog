
<form 
    action="{{$blogPost->getActionUrl()}}" 
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
                        value="{{old('name',$blogPost->name)}}"
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="@lang('Enter name')"
                        >                
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'name'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Choose New Photo')</label>
                    <input type="file" name='photo' class="form-control @error('photo') is-invalid @enderror">
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'photo'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Description')</label>
                    <textarea 
                        name='description'
                        class="form-control @error('description') is-invalid @enderror" 
                        placeholder="@lang('Enter description')"
                        >{{old('description',$blogPost->description)}}</textarea>
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'description'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Content')</label>
                    <textarea 
                        id='content-textarea'
                        name='content'
                        class="form-control @error('content') is-invalid @enderror" 
                        placeholder="@lang('Enter content')"
                        >{{old('content',$blogPost->content)}}</textarea>
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'content'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Category')</label>
                    <select name='category_id' class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">-- @lang('Choose Category') --</option>
                        @foreach($categories as $category)
                        <option 
                            value="{{$category->id}}"
                            @if(old('category_id',$blogPost->category_id) == $category->id)
                            selected
                            @endif
                            >{{$category->name}}</option>
                        @endforeach
                    </select>
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'category_id'
                    ])
                </div>
                <div class="form-group">
                    <label>@lang('Tags')</label>
                    <select 
                        name="tag_id[]"
                        class="form-control @error('tag_id') is-invalid @enderror" 
                        multiple
                        data-placeholder="@lang('Select a Tags')"
                        >
                        @foreach($tags as $tag)
                        <option 
                            value="{{$tag->id}}"
                            @if(
                            is_array(old('tag_id',optional($blogPost->tags)->pluck('id')->toArray()))
                            && in_array($tag->id, old('tag_id',optional($blogPost->tags)->pluck('id')->toArray()))
                            )
                            selected
                            @endif
                            >{{$tag->name}}</option>
                        @endforeach
                    </select>
                    @include('admin._layout.partials.form_errors',[
                    'fieldName' => 'tag_id'
                    ])
                </div>               
            </div>
            <div class="offset-md-3 col-md-3">
                @if($blogPost->exists)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('Photo')</label>
                            <div class="text-center">
                                <img src="{{$blogPost->getPhotoUrl()}}" alt="{{$blogPost->name}}" class="img-fluid" data-container='photo'>
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
        <a href="{{route('admin.blog_posts.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
    </div>
</form>
@push('footer_javascript')
<script src="{{url('/themes/admin/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$('#content-textarea').ckeditor({
    "height": "400px"
});
//select name=product_category_id
$('#entity-form [name="category_id"]').select2({
    "theme": "bootstrap4"
});

$('#entity-form [name="tag_id[]"]').select2({
    "theme": "bootstrap4"
});
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
            "rangelength": [20, 255]
        },
        "photo": {
        },
        "description": {
            "required": true,
            "rangelength": [50, 500]
        },
        "content": {
        },
        "category_id": {
            "required": true
        },
        "tag_id[]": {
            "required": true
        }
    },
    "errorElement": "span",
    "errorPlacement": function (error, element) {
        error.appendTo($(element).closest('.form-group').find('.invalid-feedback'));
    }
});
</script>
@endpush