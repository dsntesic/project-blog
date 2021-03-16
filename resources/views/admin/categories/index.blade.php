@extends('admin._layout.layout')

@section('seo_title',__('All categories'))

@push('head_links')
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('title',__('Categories'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Categories')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Categories')</h3>
                        <div class="card-tools">
                            <form  style='display:none' id="change-priority-form" class="btn-group" action="{{route('admin.categories.change_priorities')}}" method="post">
                                @csrf
                                <input type="hidden" name="category_ids" value="">
                                <input type="hidden" name="priorities" value="">

                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-check"></i>
                                    @lang('Save Order')
                                </button>
                                <button type="button" data-action="hide-order" class="btn btn-outline-danger">
                                    <i class="fas fa-remove"></i>
                                    @lang('Cancel')
                                </button>
                            </form>
                            <button data-action="show-order" class="btn btn-outline-secondary">
                                <i class="fas fa-sort"></i>
                                @lang('Change Order')
                            </button>
                            <a href="{{route('admin.categories.create')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Create new Category')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id='entity-list'>
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center">@lang('Priority')</th>
                                    <th style="width: 30%;">@lang('Name')</th>
                                    <th style="width: 30%;">@lang('Description')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Last Change')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
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
<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$('#change-priority-form').on('submit',function(e){
    e.preventDefault();
    e.stopPropagation();
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
        toastr.error("@lang('Some error occured while changing priority of category')");
    });
    
});
$("#sortable-list").sortable({
    "handle": '.handle',
    "update": function (event, ui) {       
        let priorities = $("#sortable-list").sortable("toArray", {
            "attribute": "data-priority-id"
        });
        $("#change-priority-form [name='priorities']").val(priorities.join(","));
    }
});
$('[data-action="show-order"]').on('click', function () {
    let category_ids = $("#sortable-list").sortable("toArray", {
            "attribute": "data-id"
    });
    $("#change-priority-form [name='category_ids']").val(category_ids.join(","));
    $('#sortable-list .handle').show();
    $(this).hide();
    $('#change-priority-form').show();
});

$('[data-action="hide-order"]').on('click', function () {

    $('#sortable-list .handle').hide();
    $('[data-action="show-order"]').show();
    $('#change-priority-form').hide();
    entitiesDatatable.ajax.reload(null, false);
});

let entitiesDatatable = $('#entity-list').on('processing.dt', function () {
    $('#sortable-list .handle').hide();
    $('[data-action="show-order"]').show();
    $('#change-priority-form').hide();
}).DataTable({
    "serverSide": true,
    "processing": true,
    "ajax": {
        "url": "{{route('admin.categories.datatable')}}",
        "type": "POST",
        "data": {
            "_token": "{{csrf_token()}}"
        }
    },
    "lengthMenu": [5, 10, 25, 50, 75, 100],
    "order": [[1, 'asc']],
    "columns": [
        {"name": "id", "data": "id"},
        {"name": "priority", "data": "priority"},
        {"name": "name", "data": "name"},
        {"name": "description", "data": "description"},
        {"name": "created_at", "data": "created_at", "className": "text-center"},
        {"name": "updated_at", "data": "updated_at", "className": "text-center"},
        {"name": "actions", "data": "actions", "searchable": false, "orderable": false, "className": "text-center"}
    ],
    "createdRow": function (row, data, dataIndex) {
        let dataValue = data.id.trim().substring(data.id.lastIndexOf('#') + 1); 
        $(row).attr('data-id', dataValue);
        $(row).attr('data-priority-id', data.priority);
    }
});
$('#entity-list').on('click', "[data-action='delete']", function (e) {

    let categoryId = $(this).data('id');
    let categoryName = $(this).data('name');

    $("#custom-modal").attr('action', "{{route('admin.categories.delete')}}");
    $("#custom-modal input[name='id']").val(categoryId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Delete Category')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to delete category?')");
    $("#custom-modal [data-modal-body='name']").text(categoryName);
    $("#custom-modal .modal-footer [type='submit']").text("@lang('Delete')");
    $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger');
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
        toastr.error("@lang('Some error occured while deleting category')");
    });
});
</script>
@endpush



