
<div class="container-fuid bg-dark text-white">
    <div class="row ">
        <div class="col-9 p-4">Aplicação</div>
        
        <div class="col-3 text-right p-2"> <a href="{{route('perfil')}}"><img src="assets\fotos_usuarios\{{(session('usuario'))->foto}}" style="border-radius: 30px; height: 50px;  width: 50px;"></a> {{session('usuario')['email']}} | <a href="{{route('logout')}}">Sair</a></div>
    </div>
</div>