@extends('admin._layout.layout')

@section('seo_title',__('Edit tags'))

@section('title',__('Edit tag'))

@section('breadcrump')
<li class="breadcrumb-item"><a href='{{route('admin.tags.index')}}'>@lang('Tags')</a></li>
<li class="breadcrumb-item active">@lang('Edit tag')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Tag Form')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include('admin.tags.partials.form',[
                        'tag' => $tag
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



