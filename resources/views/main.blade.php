<!DOCTYPE html>
<html lang="en">

    @include('includes/header')

    <!-- Navigation -->
    @include('includes/navigation')
    
<body>

    @yield('content')
    
</body>

    @include('includes/footer')

    @yield('script')
    
</html>