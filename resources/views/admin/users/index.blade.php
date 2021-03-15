@extends('admin._layout.layout')

@section('seo_title',__('All users'))

@section('title',__('Users'))

@section('breadcrump')
<li class="breadcrumb-item active">@lang('Users')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Search Users')</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.users.create')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Create new User')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-1 form-group">
                                    <label>@lang('Status')</label>
                                    <select name='status' class="form-control">
                                        <option value=''>@lang('-- All --')</option>
                                        <option value="1">@lang('active')</option>
                                        <option value="0">@lang('ban')</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang('Email')</label>
                                    <input type="text" name="email" class="form-control" placeholder="@lang('Search by email')">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" name='name' class="form-control" placeholder="@lang('Search by name')">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang('Phone')</label>
                                    <input type="text" name='phone' class="form-control" placeholder="@lang('Search by phone')">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Users</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id='entity-list'>
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 20px">@lang('Status')</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Phone')</th>
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
$("#entities-filter-form [name='status']").select2({
    'theme': 'bootstrap4'
});
$('#entities-filter-form').on('change keyup change',function(e){
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
       "url": "{{route('admin.users.datatable')}}",
       "type": "POST",       
       "data": function(dtData){
           dtData._token = "{{csrf_token()}}";
           dtData.status = $("#entities-filter-form [name='status']").val();
           dtData.email = $("#entities-filter-form [name='email']").val();
           dtData.name = $("#entities-filter-form [name='name']").val();
           dtData.phone = $("#entities-filter-form [name='phone']").val();
       }      
    },
    "lengthMenu": [5, 10, 25, 50, 75, 100 ],
    "order": [[ 6, 'desc' ]],
    "columns": [
        {"name": "id", "data": "id"},       
        {"name": "status", "data": "status", "className": "text-center"},       
        {"name": "photo", "data": "photo","searchable": false,"orderable": false, "className": "text-center"},         
        {"name": "email", "data": "email"},     
        {"name": "name", "data": "name"},       
        {"name": "phone", "data": "phone","orderable": false},       
        {"name": "created_at", "data": "created_at", "className": "text-center"},      
        {"name": "actions", "data": "actions", "searchable": false, "orderable":false, "className": "text-center"}      
    ]
});
$('#entity-list').on('click', "[data-action='ban']", function (e) {

    let userId = $(this).data('id');
    let userName = $(this).data('name');

    $("#custom-modal").attr('action',"{{route('admin.users.ban')}}");
    $("#custom-modal input[name='id']").val(userId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Ban User')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to ban user?')");
    $("#custom-modal [data-modal-body='name']").text(userName);
    $("#custom-modal .modal-footer [type='submit']").text("@lang('Ban')");
    $("#custom-modal .modal-footer [type='submit']").addClass('btn-danger').removeClass('btn-success');
});
$('#entity-list').on('click', "[data-action='active']", function (e) {

    let userId = $(this).data('id');
    let userName = $(this).data('name');

    $("#custom-modal").attr('action',"{{route('admin.users.active')}}");
    $("#custom-modal input[name='id']").val(userId);
    $("#custom-modal .modal-header .modal-title").text("@lang('Activate The User')");
    $("#custom-modal [data-modal-body='text']").text("@lang('Are you sure you want to activate the user?')");
    $("#custom-modal [data-modal-body='name']").text(userName);
    $("#custom-modal .modal-footer [type='submit']").text("@lang('Activate')");
    $("#custom-modal .modal-footer [type='submit']").addClass('btn-success').removeClass('btn-danger');
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
        toastr.error("@lang('Some error occured while changing user')");
    });
});
</script>
@endpush



