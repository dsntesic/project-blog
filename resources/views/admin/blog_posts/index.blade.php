@extends('admin._layout.layout')

@section('seo_title',__('All Blog Posts'))

@section('title',__('Blog Posts'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Blog Posts')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Blog Posts')</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.blog_posts.create')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Create new Blog Post')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" name='name' class="form-control" placeholder="@lang('Search by name')">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang('Category')</label>
                                    <select name='category_id' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        @foreach($categories as $category)
                                        <option 
                                            value="{{$category->id}}"
                                            >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang('Autor')</label>
                                    <select name='user_id' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        @foreach($autors as $autor)
                                        <option 
                                            value="{{$autor->id}}"
                                            >{{$autor->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>@lang('Status')</label>
                                    <select name='status' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        <option value="1">@lang('enable')</option>
                                        <option value="0">@lang('disable')</option>
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>@lang('Important')</label>
                                    <select name='important' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        <option value="1">@lang('yes')</option>
                                        <option value="0">@lang('no')</option>
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <label>@lang('Tags')</label>
                                    <select 
                                        name="tag_id[]"
                                        class="form-control" 
                                        multiple
                                        data-placeholder="@lang('Select a Tags')"
                                        >
                                        @foreach($tags as $tag)
                                        <option 
                                            value="{{$tag->id}}"
                                            >{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                    @include('admin._layout.partials.form_errors',[
                                    'fieldName' => 'tag_id'
                                    ])
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id='entity-list'>
                            <thead>                  
                                <tr>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th class="text-center" title='Status'>@lang('ST')</th>
                                    <th class="text-center" title='Important'>@lang('IMP')</th>
                                    <th style="width: 30%;">@lang('Category')</th>
                                    <th style="width: 30%;">@lang('Name')</th>
                                    <th class="text-center">@lang('Comments')</th>
                                    <th class="text-center">@lang('Reviews')</th>
                                    <th style="width: 30%;">@lang('Autor')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal-->
@include('admin._layout.partials.modal')
<!-- /.Modal -->
@endsection
@push('footer_javascript')
<script type="text/javascript">
    $("#entities-filter-form [name='category_id']").select2({
        'theme': 'bootstrap4'
    });
    $("#entities-filter-form [name='user_id']").select2({
        'theme': 'bootstrap4'
    });
    $("#entities-filter-form [name='tag_id[]']").select2({
        'theme': 'bootstrap4'
    });
    $("#entities-filter-form [name='status']").select2({
        'theme': 'bootstrap4'
    });
    $("#entities-filter-form [name='important']").select2({
        'theme': 'bootstrap4'
    });
    $('#entities-filter-form').on('change keyup',function(e){
        e.preventDefault();
        $(this).trigger('submit');
    });
     $('#entities-filter-form').on('submit',function(e){
        e.preventDefault();
        entitiesDatatable.ajax.reload(null,true);
     });
    let entitiesDatatable = $('#entity-list').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "{{route('admin.blog_posts.datatable')}}",
            "type": "POST",
            "data": function (dtData) {
                dtData._token = "{{csrf_token()}}";
                dtData.name =  $("#entities-filter-form [name='name']").val();
                dtData.category_id =  $("#entities-filter-form [name='category_id']").val();
                dtData.user_id =  $("#entities-filter-form [name='user_id']").val();
                dtData.status =  $("#entities-filter-form [name='status']").val();
                dtData.important =  $("#entities-filter-form [name='important']").val();
                dtData.tag_id =  $("#entities-filter-form [name='tag_id[]']").val();
            }
        },
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        "order": [[8, 'desc']],
        "columns": [
            {"name": "photo", "data": "photo", "searchable": false, "orderable": false},
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "important", "data": "important", "className": "text-center"},
            {"name": "category_name", "data": "category_name","orderable": false},
            {"name": "name", "data": "name"},
            {"name": "comments", "data": "comments","orderable": false},
            {"name": "reviews", "data": "reviews"},
            {"name": "autor_name", "data": "autor_name"},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "searchable": false, "orderable": false, "className": "text-center"}
        ]
    });

    $('#entity-list').on('click', "[data-action='delete']", function (e) {

        let blogPostId = $(this).data('id');
        let blogPostName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.blog_posts.delete')}}");
        $("#custom-modal input[name='id']").val(blogPostId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Delete Blog Post')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to delete Blog Post?')");
        $("#custom-modal [data-modal-body='name']").text(blogPostName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('Delete')");
        $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger').removeClass('btn-success');
    });

    $('#entity-list').on('click', "[data-action='enable']", function (e) {

        let blogPostId = $(this).data('id');
        let blogPostName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.blog_posts.enable')}}");
        $("#custom-modal input[name='id']").val(blogPostId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Enable Blog Post')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to enable Blog Post?')");
        $("#custom-modal [data-modal-body='name']").text(blogPostName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('Enable')");
        $("#custom-modal .modal-footer [type='submit']").addClass('btn-success').removeClass('btn-danger');
    });

    $('#entity-list').on('click', "[data-action='disable']", function (e) {

        let blogPostId = $(this).data('id');
        let blogPostName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.blog_posts.disable')}}");
        $("#custom-modal input[name='id']").val(blogPostId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Disable Blog Post')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to disable Blog Post?')");
        $("#custom-modal [data-modal-body='name']").text(blogPostName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('Disable')");
        $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger').removeClass('btn-success');
    });

    $('#entity-list').on('click', "[data-action='important']", function (e) {

        let blogPostId = $(this).data('id');
        let blogPostName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.blog_posts.important')}}");
        $("#custom-modal input[name='id']").val(blogPostId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Set Blog Post to be important')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to set Blog Post to be important?')");
        $("#custom-modal [data-modal-body='name']").text(blogPostName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('Important')");
        $("#custom-modal .modal-footer [type='submit']").addClass('btn-success').removeClass('btn-danger');
    });

    $('#entity-list').on('click', "[data-action='noImportant']", function (e) {

        let blogPostId = $(this).data('id');
        let blogPostName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.blog_posts.no_important')}}");
        $("#custom-modal input[name='id']").val(blogPostId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Set Blog Post to be no important')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to set Blog Post to be no important?')");
        $("#custom-modal [data-modal-body='name']").text(blogPostName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('No important')");
        $("#custom-modal .modal-footer [type='submit']").addClass('.btn-danger').removeClass('btn-success');
    });

    $('#custom-modal').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),
            "type": $(this).attr('method'),
            "data": $(this).serialize()
        })
        .done(function (response) {
            toastr.success(response.system_message);
            entitiesDatatable.ajax.reload(null, false);
        })
        .fail(function () {
            toastr.error("@lang('Some error occured while changing Blog Post')");
        });
    });
</script>
@endpush



