
@extends('frm_login')
@section('conteudo')

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4 offset-sm-4">
            {{--inicio formulario--}}
            <form action="{{route('frm_submit')}}" method="post">
             @csrf
                <h4>Login</h4>
                <hr>
                <div class="form-group">
                    <label>Usuario</label> 
                    <input type="email" name="text_email" class="form-control">           
                </div>
                <div class="form-group">
                    <label>Senha</label> 
                    <input type="password" name="text_senha" class="form-control">           
                </div>
                <div class="form-group">
                    <br>
                    <input type="submit" value="Entrar" class="btn btn-primary">  
                    <a href="{{route('cadastro')}}" class="btn btn-secondary">Cadastre-se</a>
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