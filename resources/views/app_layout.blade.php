<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/bootstrap.min.css')}}">
    <title>Document</title>
    
</head>
<body>
    @include('cabecario')
    @yield('home')
    <script src="{{asset('assets/3de5dfddc3.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/jquery.min.js')}}"></script>

</body>
</html>