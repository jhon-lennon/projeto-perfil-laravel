

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

    
<div class="container-fuid bg-dark text-white">
    <div class="row ">
        <div class="col-9 p-4">Aplicação</div>
        
        <div class="col-3 text-right p-2"> <a href="{{route('perfil')}}"><img src="../assets/fotos_usuarios/{{(session('usuario'))->foto}}" style="border-radius: 30px; height: 50px;  width: 50px;"></a> {{session('usuario')['email']}} | <a href="{{route('logout')}}">Sair</a></div>
    </div>
</div>
    <div class="container-fuid">
        <div class="row">
            <div class="col">
                
                <h3 class="text-center mb-5">Editar Tarefa</h3>
                <form action="{{route('tarefaUpdate')}}" method="post">
                    @csrf
                    <input type="hidden" name="id_task" value="{{$tarefa->id}}">
                        <div class="row">
    
                            <div class="col-sm-4 offset-sm-4">
                                <hr>
                                <div class="form-group">
                                    <label for="criar_tarefa">Editar Tarefa:</label>
                                    <br>
                                    <input type="text" value="{{$tarefa->tarefas}}" name="text_task" id="criar" class="form-control">
                                    
    
                                        <div class="form-group">
                                            <br>
                                            <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
                                            <a href="{{route('home')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                                        </div>
                                        @if ($errors->any())
            
                                        <div class="alert alert-danger mt-2">
                                            <ul>
                                                
                                                @foreach ($errors->all() as $mensagens)
                                                    <li>{{$mensagens}}</li>
                                                @endforeach
                                             </ul>
                                        </div> 
                                    @endif
    
                                </div>
    
                            </div>
    
                        </div>
                
                </form>
    
            </div>
    
        </div>
    
    </div>
    <script src="{{asset('assets/3de5dfddc3.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/jquery.min.js')}}"></script>

</body>
</html>
