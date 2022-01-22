<!DOCTYPE html>


@extends('layouts/layout_main')

@section('home')

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('asset/bootstrap/bootstrap.min.css')}}">
    <script src="{{asset('asset/jquery.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/3de5dfddc3.js" crossorigin="anonymous"></script>

    
    <title>tarefas</title>
</head>
<body>
    <script src="<?=asset('asset/bootstrap/bootstrap.bundle.min.js')?>"></script>
    @yield('home')
</body>
</html>
@andsection

