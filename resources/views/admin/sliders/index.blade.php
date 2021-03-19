@extends('admin._layout.layout')

@section('seo_title',__('All sliders'))

@push('head_links')
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('title',__('Sliders'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Sliders')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Sliders')</h3>
                        <div class="card-tools">
                            <form  style='display:none' id="change-priority-form" class="btn-group" action="{{route('admin.sliders.change_priorities')}}" method="post">
                                @csrf
                                <input type="hidden" name="slider_ids" value="">
                                <input type="hidden" data-page='page' name="page" value="">
                                <input type="hidden" data-lenght='length' name="length" value="">

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
                            <a href="{{route('admin.sliders.create')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Create new Slider')
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
                                    <th class="text-center">@lang('Photo')</th>
                                    <th style="width: 30%;">@lang('Name')</th>
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
        toastr.error("@lang('Some error occured while changing priority of slider')");
    });
    
});
$("#sortable-list").sortable({
    "handle": '.handle',
    "update": function (event, ui) {       
        let priorities = $("#sortable-list").sortable("toArray", {
            "attribute": "data-id"
        });
        $("#change-priority-form [name='slider_ids']").val(priorities.join(","));
    }
});
$('[data-action="show-order"]').on('click', function () {
    $(this).hide();
    $('#sortable-list .handle').show();
    var infoDataTable = entitiesDatatable.page.info();
    $("[data-page='page']").val(infoDataTable.page);
    $("[data-lenght='length']").val(infoDataTable.length);
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
        "url": "{{route('admin.sliders.datatable')}}",
        "type": "POST",
        "data": function (dtData) {
            dtData._token = "{{csrf_token()}}";
        }
    },
    "lengthMenu": [5, 10, 25, 50, 75, 100],
    "order": [[1, 'asc']],
    "columns": [
        {"name": "id", "data": "id"},
        {"name": "priority", "data": "priority"},       
        {"name": "photo", "data": "photo","searchable": false,"orderable": false, "className": "text-center"}, 
        {"name": "name", "data": "name"},
        {"name": "created_at", "data": "created_at", "className": "text-center"},
        {"name": "updated_at", "data": "updated_at", "className": "text-center"},
        {"name": "actions", "data": "actions", "searchable": false, "orderable": false, "className": "text-center"}
    ],
    "createdRow": function (row, data, dataIndex) {
        let dataValue = data.id.trim().substring(data.id.lastIndexOf('#') + 1); 
        $(row).attr('data-id', dataValue);
    }
});

$('#entity-list').on('click', "[data-action='enable']", function (e) {

    let sliderId = $(this).data('id');
    let sliderName = $(this).data('name');

    $("#custom-modal").attr('action', "{{route('admin.sliders.enable')}}");
    $("#custom-modal input[name='id']").val(sliderId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Enable Slider')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to enable Slider?')");
    $("#custom-modal [data-modal-body='name']").text(sliderName);
    $("#custom-modal .modal-footer [type='submit']").text("@lang('Enable')");
    $("#custom-modal .modal-footer [type='submit']").addClass('btn-success').removeClass('btn-danger');
});

$('#entity-list').on('click', "[data-action='disable']", function (e) {

    let sliderId = $(this).data('id');
    let sliderName = $(this).data('name');

    $("#custom-modal").attr('action', "{{route('admin.sliders.disable')}}");
    $("#custom-modal input[name='id']").val(sliderId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Disable Slider')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to disable Slider?')");
    $("#custom-modal [data-modal-body='name']").text(sliderName);
    $("#custom-modal .modal-footer [type='submit']").text("@lang('Disable')");
    $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger').removeClass('btn-success');
});
    
$('#entity-list').on('click', "[data-action='delete']", function (e) {

    let sliderId = $(this).data('id');
    let sliderName = $(this).data('name');

    $("#custom-modal").attr('action', "{{route('admin.sliders.delete')}}");
    $("#custom-modal input[name='id']").val(sliderId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Delete Slider')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to delete slider?')");
    $("#custom-modal [data-modal-body='name']").text(sliderName);
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
        toastr.error("@lang('Some error occured while deleting slider')");
    });
});
</script>
@endpush



