@extends('admin._layout.layout')

@section('seo_title',__('Create users'))

@section('title',__('Create new user'))

@section('breadcrump')
<li class="breadcrumb-item"><a href='{{route('admin.users.index')}}'>@lang('Users')</a></li>
<li class="breadcrumb-item active">@lang('New user')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('User Form')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include('admin.users.partials.form',[
                        'user' => $user
                    ])
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



