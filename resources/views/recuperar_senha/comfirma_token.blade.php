@extends('frm_login')
@section('conteudo')

        <div class="container-fuid">
            <div class="row">
                <div class="col">
                    <hr>
            
                    <h3 class="text-center mb-5">Confirme o Codigo</h3>
                    <form action="{{route('recuperar_senha_token')}}" method="post">
                        @csrf
                            <div class="row">
        
                                <div class="col-sm-4 offset-sm-4">
        
                                    <div class="form-group">
                                        <label>Codigo de confirmação:</label>
                                        <br>
                                        
                                        <input type="text" name="frm_token" id="criar" class="form-crontrol">
                                        <br>
                                        <p>Verifique sua caixa de entrada ou o lixo eletronico.</p>
                                      
                                        
        
                                            <div class="form-group">
                                                
                                                <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
                                                <a href="{{route('home')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                                            </div>
                                                  @if (isset($erro))
          
                                                      <div class="alert alert-danger text-center">{{$erro}}</div>
                        
                                                @endif
        
                                    </div>
        
                                </div>
        
                            </div>
                    
                    </form>


        
                </div>
        
            </div>
        
        </div>
        
        @endsection  
