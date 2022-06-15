@extends('app_layout')

@section('home')
    <div class="container-fuid">
        <div class="row">
            <div class="col">

              
                <h3 class="text-center mb-5">Nova Tarefa</h3> 
              
                <form action="{{ route('tarefaCreate') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-sm-4 offset-sm-4">
                            <hr>
                            <div class="form-group">
                                <label for="criar_tarefa">Nova Tarefa:</label>
                                <br>
                                <input type="text" name="new_task" id="criar" class="form-control">


                                <div class="form-group">
                                    <br>
                                    <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
                                    <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">Cancelar</a>
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
@endsection
