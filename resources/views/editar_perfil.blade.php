@extends('app_layout')
@section('home')

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4 offset-sm-4">
            {{--inicio formulario--}}
            <form action="{{route('editar_perfil_usuario')}}" method="post">
             @csrf
                <h4>Editar dados</h4>
                <hr>
                <div class="form-group">
                    <label>Nome</label> 
                    <input type="text" name="text_nome" class="form-control"> 

                </div>
                <div class="form-group">
                    <label>Email</label> 
                    <input type="email" name="text_email" class="form-control"> 
                              
                </div>
                <hr>
                <div class="form-group">
                    <label>Senha</label> 
                    <input type="password" name="text_senha" class="form-control">           
                </div>
                <div class="form-group">
                    <br>
                    <input type="submit" value="Atualizar" class="btn btn-primary"> 
                    <a href="{{route('editar_senha')}}" class="btn btn-primary">Alterar Senha</a>
                    <a href="{{route('perfil')}}" class="btn btn-secondary">Cancelar</a>
                    
                </div> 

            </form><br>
            {{--final formulario formulario--}}
            
            {{-------------------------------}}

            {{------validaçao de formulario----}}
            @if ($errors->any())
            
                <div class="alert alert-danger">
                    <ul>
                        
                        @foreach ($errors->all() as $mensagens)
                            <li>{{$mensagens}}</li>
                        @endforeach
                     </ul>
                </div> 
            @endif
            {{--validaçao dos dados----------}}
            @if (isset($erro))
          
            <div class="alert alert-danger text-center">{{$erro}}</div>
                
            @endif
            @if (isset($alterado))
          
            <div class="alert alert-success text-center">{{$alterado}} <a href="{{route('perfil')}}"class="alert-link">Ver perfil</a></div>
                
            @endif
        </div>

       
    </div>
</div>


@endsection