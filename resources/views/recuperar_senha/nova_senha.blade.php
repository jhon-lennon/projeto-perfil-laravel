@extends('frm_login')
@section('conteudo')

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4 offset-sm-4">
            {{--inicio formulario--}}
            <form action="{{route('recuperando_senha')}}" method="post">
             @csrf
                <h4>Recuperar Senha</h4>
                <hr>
                <p>Nome: {{session('nome')}}</p>
                <p>Email: {{session('email')}}</p>
                
                <div class="form-group">
                    <label>Nova Senha</label> 
                    <input type="password" name="nova_senha" class="form-control">           
                </div>
                <div class="form-group">
                    <label>Confirmar Nova Senha</label> 
                    <input type="password" name="confirma_senha" class="form-control">           
                </div>
                    <br>
                    <input type="submit" value="Confirmar" class="btn btn-primary">  
                    <a href="{{route('login')}}" class="btn btn-secondary">Cancelar</a>  
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
            
        </div>
    </div>
</div>


@endsection