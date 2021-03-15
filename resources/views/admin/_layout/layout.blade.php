<!DOCTYPE html>
<html lang="en">
    @include('admin._layout.partials.head')
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            
            <!-- Navbar -->
            @include('admin._layout.partials.navbar')
            <!-- /.navbar -->
            
            <!-- Main Sidebar Container -->
            @include('admin._layout.partials.sidebar')
            <!-- /.Main Sidebar Container -->
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                
                <!-- Content Header (Page header) -->              
                @include('admin._layout.partials.page_header') 
                <!-- /.content-header -->

                <!-- Main content -->
                @yield('content')
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            
            <!-- Main Footer -->              
            @include('admin._layout.partials.footer')
            <!-- /.Main Footer -->
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->              
        @include('admin._layout.partials.javascript')
    </body>
</html>


