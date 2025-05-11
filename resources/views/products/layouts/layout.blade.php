<!DOCTYPE html>
<html>

<head>
    <title>{{ @$title }}</title>
    @include('products.includes.header')
</head>

<body>
    @include('products.includes.header')
    @yield('content')
    @stack('scripts')
    @include('products.includes.footer')
</body>

</html>
