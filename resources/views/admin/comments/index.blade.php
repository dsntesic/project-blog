@extends('admin._layout.layout')

@section('seo_title',__('All Comments'))

@section('title',__('Comments'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Comments')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Comments')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row flex-row-reverse">
                                <div class="col-md-4 form-group">
                                    <label>@lang('Blog Post')</label>
                                    <select name='blog_post_id' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        @foreach($blogPosts as $blogPost)
                                        <option 
                                            value="{{$blogPost->id}}"
                                            >{{$blogPost->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang('Status')</label>
                                    <select name='status' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        <option value="1">@lang('enable')</option>
                                        <option value="0">@lang('disable')</option>
                                    </select>
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
                                    <th class="text-center">@lang('Status')</th>
                                    <th style="width: 20%;">@lang('Name')</th>
                                    <th style="width: 20%;">@lang('Email')</th>
                                    <th style="width: 30%;">@lang('Blog Post')</th>
                                    <th style="width: 30%;">@lang('Comment Message')</th>
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
    $("#entities-filter-form [name='blog_post_id']").select2({
        'theme': 'bootstrap4'
    });
    $("#entities-filter-form [name='status']").select2({
        'theme': 'bootstrap4'
    });
    $('#entities-filter-form').on('change',function(e){
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
            "url": "{{route('admin.comments.datatable')}}",
            "type": "POST",
            "data": function (dtData) {
                dtData._token = "{{csrf_token()}}";
                dtData.status =  $("#entities-filter-form [name='status']").val();
                dtData.blog_post_id =  $("#entities-filter-form [name='blog_post_id']").val();
            }
        },
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        "order": [[5, 'desc']],
        "columns": [
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "name", "data": "name"},
            {"name": "email", "data": "email"},
            {"name": "blog_post_name", "data": "blog_post_name"},
            {"name": "message", "data": "message"},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "searchable": false, "orderable": false, "className": "text-center"}
        ]
    });

    $('#entity-list').on('click', "[data-action='enable']", function (e) {

        let commentId = $(this).data('id');
        let commentName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.comments.enable')}}");
        $("#custom-modal input[name='id']").val(commentId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Enable Comment')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to enable Comment?')");
        $("#custom-modal [data-modal-body='name']").text(commentName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('Enable')");
        $("#custom-modal .modal-footer [type='submit']").addClass('btn-success').removeClass('btn-danger');
    });

    $('#entity-list').on('click', "[data-action='disable']", function (e) {

        let commentId = $(this).data('id');
        let commentName = $(this).data('name');

        $("#custom-modal").attr('action', "{{route('admin.comments.disable')}}");
        $("#custom-modal input[name='id']").val(commentId);
        $("#custom-modal .modal-header .modal-title").text("@lang('Disable Comment')");
        $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to disable Comment?')");
        $("#custom-modal [data-modal-body='name']").text(commentName);
        $("#custom-modal .modal-footer [type='submit']").text("@lang('Disable')");
        $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger').removeClass('btn-success');
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
            toastr.error("@lang('Some error occured while changing Comment')");
        });
    });
</script>
@endpush



