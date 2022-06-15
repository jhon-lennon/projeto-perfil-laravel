@extends('app_layout')

@section('home')

@php
    Use App\Classes\Enc;
    $enc = new enc();
@endphp

<div class="container-fuid">
    <div class="row">
        <div class="col">
            <h3>Lista de tarefas</h3>
            <hr>
            <div class="my-2">
                <a href="{{route('nova_tarefa')}}" class="btn btn-primary">Criar Tarefa</a>
                <a href="{{route('invisivel_tarefa')}}" class="btn btn-primary">Tatefas invisíveis</a>
                <a href="{{route('home')}}" class="btn btn-primary">inicio</a>

            </div>

            @if ($tarefa->count() == 0)
            <p>não existe tarefas disponives</p>
           
                
            @else
            <table class="table table-striped">
                <thead style="background-color: rgb(59, 59, 59); color:rgb(255, 247, 247)">
                    <tr>
                        <th>Tarefas</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <body>
                    
                    @foreach ($tarefa as $tare)
                        <tr>
                            <td style="width: 70%">{{$tare->tarefas}}</td>

                            <td>
                             
                                @if ($tare->concluido == null)
                                
                                    <a href="{{route('concluido',['id'=> $enc->encriptar( $tare->id)])}}" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></a>
    
                                    @else
                                        <a href="{{route('afazer',['id'=> $enc->encriptar( $tare->id)])}}" class="btn btn-success btn-sm"><i class="fa fa-times"></i></a>
                                @endif

                                @if ($tare->visivel == null)
                                
                                    <a href="{{route('invisivel',['id'=> $enc->encriptar( $tare->id)])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye-slash"></i></a>
    
                                    @else
                                        <a href="{{route('visibilidade',['id'=> $enc->encriptar( $tare->id)])}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                @endif

                                <a href="{{route('editar_tarefa',['id'=> $enc->encriptar( $tare->id)])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>

                                <a href="{{route('tarefaDelete',['id'=> $tare->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-trash"></i></a>

                            </td>  
                                                  
                        </tr>
                    @endforeach
                    <td> Total: {{ $tarefa->count()}}</td> 
                    <td></td> 
                @endif
            </body>
            </table>

        </div>

    </div>

</div>

@endsection