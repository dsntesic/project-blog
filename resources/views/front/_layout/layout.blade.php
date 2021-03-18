<!DOCTYPE html>
<html>
    <!-- Head-->
    @include('front._layout.partials.head')
    <!-- /.head -->
    <body>
        <header class="header">
            <!-- Main Navbar-->
            @include('front._layout.partials.navbar')
        </header>
        
        @yield('content')
        <!-- Page Footer-->
        @include('front._layout.partials.footer')
        <!-- JavaScript files-->
        @include('front._layout.partials.javascript')       
    </body>
</html>