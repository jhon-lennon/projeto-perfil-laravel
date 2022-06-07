@extends('frm_login')
@section('conteudo')

<div class="container">
    <div class="row mt-5">
        <div class="col-sm-4 offset-sm-4">
            {{--inicio formulario--}}
            <form action="{{route('cadastrar')}}" method="post" enctype="multipart/form-data">
             @csrf
                <h4>Cadastrar</h4>
                <hr>
                <div class="form-group">
                    <label>Nome</label> 
                    <input type="text" name="text_nome" class="form-control"> 

                </div>
                <div class="form-group">
                    <label>Email</label> 
                    <input type="email" name="text_email" class="form-control"> 
                              
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Foto do perfil</label>
                    <input type="file" class="form-control" name="foto" aria-label="Upload" accept="image/*">
                  </div>
                <div class="form-group">
                    <label>Senha</label> 
                    <input type="password" name="text_senha" class="form-control">           
                </div>
                <div class="form-group">
                    <label>confirmar senha</label> 
                    <input type="password" name="text_senha_confirma" class="form-control">           
                </div>
                <div class="form-group">
                    <br>
                    <input type="submit" value="Cadastrar" class="btn btn-primary">  
                    <a href="{{route('login')}}" class="btn btn-secondary">Login</a>  
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