@extends('frm_login')
@section('conteudo')

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4 offset-sm-4">
            {{--inicio formulario--}}
            <form action="{{route('recuperar_senha_frm')}}" method="post">
             @csrf
                <h4>Recuperar Senha</h4>
                <hr>
                <div class="form-group">
                    <label>Email</label> 
                    <input type="email" name="text_email" class="form-control"> 
                <div class="form-group">
                    <br>
                    <input type="submit" value="Enviar" class="btn btn-primary">  
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