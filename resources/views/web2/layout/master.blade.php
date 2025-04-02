<!DOCTYPE html>
<html lang="en">
<head>
    @include('web2.layout.css')
    @include('web2.layout.header')
</head>
<body>
    @yield('content')

    @include('web2.layout.footer')

    @include('web2.layout.js')
</body>
</html>
