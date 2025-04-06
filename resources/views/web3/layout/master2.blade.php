<!DOCTYPE html>
<html lang="en">

<head>
    @include('web3.layout.css')
    @include('web3.layout.menu')
</head>

<body>
    @yield('content')
    @include('web3.layout.footer')



    @include('web3.layout.tab')
    @include('web3.layout.js')
</body>

</html>