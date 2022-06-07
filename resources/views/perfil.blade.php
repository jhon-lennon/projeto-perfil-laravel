@extends('app_layout')

@section('home')
    <div class="col-4 text-center offset-4 p-3">


        <h1>Meu Perfil</h1>
        <p><img src="assets\fotos_usuarios\{{ session('usuario')->foto }}"
                style="border-radius: 50px; height: 150px;  width: 150px;"></p>

        <p>Nome: {{ $usuario->nome }}</p>
        <p>Email: {{ $usuario->email }}</p>
        <p>Ultima atualização: {{ $usuario->updated_at }}</p>
        <p>Cadastrado em: {{ $usuario->created_at }}</p>
        <p>Ultimo login: {{ $usuario->Ultiomo_Login }}</p>

        <div class="my-2">
            <a href="{{ route('editar_perfil') }}" class="btn btn-primary">Editar Dados</a>
            <a href="{{ route('excluir_perfil') }}" class="btn btn-primary">Exculir conta</a>
            <a href="{{ route('home') }}" class="btn btn-primary">inicio</a>
            <p>
                @if (isset($alerta))
                    <div class="alert alert-warning text-center">{{ $alerta }} <a href="{{ route('excluir_conta') }}"
                            class="alert-link">Confirmar</a> | <a href="{{ route('perfil') }}"
                            class="alert-link">Cancelar</a></div>
                @endif


        </div>
    @endsection
