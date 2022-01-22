@extends('app_layout')

@section('home')
<div class="container-fuid">
    <div class="row">
        <div class="col">
            <h3>Minha Lista</h3>
            <hr>
            <h3 class="text-center mb-5">Nova Tarefa</h3>
            <form action="{{route('criar_tarefa')}}" method="post">
                @csrf
                    <div class="row">

                        <div class="col-sm-4 offset-sm-4">

                            <div class="form-group">
                                <label for="criar_tarefa">Nova Tarefa:</label>
                                <br>
                                <input type="text" name="nova_tarefa" id="criar" class="form-crontrol">
                                

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