
<!DOCTYPE html>
<html>
<head>
@include('web.layouts.header')
</head>
<body>
<!-- header -->
@include('web.layouts.menu')	
@yield('content')
@include('web.layouts.footer')
<!-- //footer -->
</body>
</html>