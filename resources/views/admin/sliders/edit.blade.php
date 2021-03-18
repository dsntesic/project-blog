@extends('admin._layout.layout')

@section('seo_title',__('Edit sliders'))

@section('title',__('Edit slider'))

@section('breadcrump')
<li class="breadcrumb-item"><a href='{{route('admin.sliders.index')}}'>@lang('Sliders')</a></li>
<li class="breadcrumb-item active">@lang('Edit slider')</li>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Slider Form')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    @include('admin.sliders.partials.form',[
                        'slider' => $slider
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



