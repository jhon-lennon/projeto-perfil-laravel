@extends('app_layout')

@section('home')
<div class="container-fuid">
    <div class="row">
        <div class="col">
            <h3>Minha Lista</h3>
            <hr>
    
            <h3 class="text-center mb-5">Editar Tarefa</h3>
            <form action="{{route('editar')}}" method="post">
                @csrf
                <input type="hidden" name="id_tarefa" value="{{$tarefa->id}}">
                    <div class="row">

                        <div class="col-sm-4 offset-sm-4">

                            <div class="form-group">
                                <label for="criar_tarefa">Editar Tarefa:</label>
                                <br>
                                <input type="text" value="{{$tarefa->tarefas}}" name="editar_tarefa" id="criar" class="form-crontrol">
                                

                                    <div class="form-group">
                                        <br>
                                        <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
                                        <a href="{{route('home')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                                    </div>

                            </div>

                        </div>

                    </div>
            
            </form>

        </div>

    </div>

</div>

@endsection