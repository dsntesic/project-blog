@extends('admin._layout.layout')

@section('seo_title',__('Create Blog Posts'))

@section('title',__('Create new Blog Post'))

@section('breadcrump')
<li class="breadcrumb-item"><a href='{{route('admin.blog_posts.index')}}'>@lang('Blog Posts')</a></li>
<li class="breadcrumb-item active">@lang('New blog Post')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Blog Post Form')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include('admin.blog_posts.partials.form',[
                        'blogPost' => $blogPost
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



