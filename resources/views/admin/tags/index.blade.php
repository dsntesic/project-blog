@extends('admin._layout.layout')

@section('seo_title',__('All tags'))

@section('title',__('Tags'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Tags')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Tags')</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.tags.create')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Create new Tag')
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
                                    <th>@lang('Name')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Updated At')</th>
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
let entitiesDatatable = $('#entity-list').DataTable({
    "serverSide": true,
    "processing": true,
    "ajax": {
       "url": "{{route('admin.tags.datatable')}}",
       "type": "POST",       
       "data": {
           "_token" : "{{csrf_token()}}"
       }      
    },
    "lengthMenu": [5, 10, 25, 50, 75, 100 ],
    "order": [[ 2, 'desc' ]],
    "columns": [
        {"name": "id", "data": "id"},    
        {"name": "name", "data": "name"},      
        {"name": "created_at", "data": "created_at", "className": "text-center"},      
        {"name": "updated_at", "data": "updated_at", "className": "text-center"},      
        {"name": "actions", "data": "actions", "searchable": false, "orderable":false, "className": "text-center"}      
    ]
});
$('#entity-list').on('click', "[data-action='delete']", function (e) {

    let tagId = $(this).data('id');
    let tagName = $(this).data('name');

    $("#custom-modal").attr('action',"{{route('admin.tags.delete')}}");
    $("#custom-modal input[name='id']").val(tagId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Ban Tag')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to delete tag?')");
    $("#custom-modal [data-modal-body='name']").text(tagName);
    $("#custom-modal .modal-footer [type='submit']").text("@lang('Delete')");
    $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger');
});

$('#custom-modal').on('submit',function(e){
    e.preventDefault();
    e.stopPropagation();
    $(this).modal('hide');
    $.ajax({
        "url":$(this).attr('action'),
        "type":$(this).attr('method'),
        "data":$(this).serialize()
    })
    .done(function(response){
        toastr.success(response.system_message); 
        entitiesDatatable.ajax.reload(null,false);
    })
    .fail(function(){
        toastr.error("@lang('Some error occured while changing tag')");
    });
});
</script>
@endpush



