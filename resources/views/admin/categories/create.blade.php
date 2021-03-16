@extends('admin._layout.layout')

@section('seo_title',__('Create categories'))

@section('title',__('Create new category'))

@section('breadcrump')
<li class="breadcrumb-item"><a href='{{route('admin.categories.index')}}'>@lang('Categories')</a></li>
<li class="breadcrumb-item active">@lang('New category')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Category Form')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include('admin.categories.partials.form',[
                        'category' => $category
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



