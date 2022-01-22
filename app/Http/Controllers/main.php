<?php

namespace App\Http\Controllers;
use App\Models\task;
use App\Http\Requests\loguinRequest;
use App\Http\Requests\editarUsuarioRequest;
use App\Http\Requests\altearSenhaRequest;
use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\cadastroRequest;
use DateTime;

class main extends Controller
{
    public function index()
    {
        //pegar o id na sessao se existir
        if ($this->checksessao()) {
            $id = session()->get('usuario')->id;
            
            //criar um usuario e retornar a pagina home
            $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

            return view('home', ['tarefa' => $tarefa]);
        } else {

            //voltar ao login nao nao tiver sessao
            return redirect()->route('login');
        }
    }

    // chamar view login se nao estiver logado
    public function login()
    {
        if ($this->checksessao()) {
            return redirect()->route('index');
        }
        return view('login');
    }
    //chamar a view de cadastro
    public function cadastro()
    {
        if ($this->checksessao()) {

            return redirect()->route('index');
        }

        return view('cadastrar');
    }

    //-----recebendo dados do formulario de cadastro---
    public function cadastrar(cadastroRequest $request)
    {
        //validar dados
        $request->validated();

        //pegando dados sem espaços
        $nome_usuario = trim($request->input('text_nome'));
        $email_usuario = trim($request->input('text_email'));
        $senha_usuario = trim($request->input('text_senha'));
        $senha_confirma = trim($request->input('text_senha_confirma'));


        //verivicar se o email enviado ja esta cadastrado
        $usuari = usuario::where('email', $email_usuario)->first();


        if ($usuari) {

            $erro = ['erro' => 'Email ja cadastrado.'];

            return view('cadastrar', $erro);
        }

        //comparar senha e confirmar senha
        if ($senha_usuario != $senha_confirma) {

            $erro = ['erro' => 'Senha e confirmar senha não correspondem.'];

            return view('cadastrar', $erro);
        }


    //cadastrar o usuario e retornar ou login
        $usuario = new Usuario;
        $usuario->nome = $nome_usuario;
        $usuario->email = $email_usuario;
        $usuario->senha = Hash::make($senha_usuario);
        $usuario->save();

        return redirect()->route('login');
    }

    // usar pra verificar se existe sessao 
    private function checksessao()
    {
        return session()->has('usuario');
    }

    //receber dados do formulario de login
    public function frm_submit(loguinRequest $request)
    {
        // verifica se essa function foi chamada pelo metodo poste
        if (!$request->isMethod('post')) {
            return redirect()->route('index');
        }
        // verifica se existe sessao
        if ($this->checksessao()) {
            return redirect()->route('index');
        }
        // validar dados recebidos do formulario, se ouver erro vai retornar a view com os eros
        $request->validated();

        // pegar dados sem os espaços dos campos
        $usuario = trim($request->input('text_email'));
        $senha = trim($request->input('text_senha'));


        //verificar se o usuario existe
        $usuari = usuario::where('email', $usuario)->first();
        if (!$usuari) {

            $erro = ['erro'=> 'O usuario não existe.'];
            return view('login',$erro);
        }

        // verificar a senha
        if (!hash::check($senha, $usuari->senha)) {
            $erro = ['erro'=> 'Senha incorreta.'];
            return view('login',$erro);
        }
        // iniciar a sesao e ir para o home
        session()->put('usuario', $usuari);
        return redirect()->route('index');
    }

    //chamar a pagigina inicial com as tarefas visiveis
    public function home()
    {
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        $id = session()->get('usuario')->id;

        $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

        return view('home', ['tarefa' => $tarefa]);
    }

    //----------encerrar a sessao do usuario---------------

    public function logout(){
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        session()->forget('usuario');
        return redirect()->route('index');
    }
//-----------alterar a senha---------------------------
    public function editar_senha(){
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        return view('alterar_senha');
    }

    public function alterando_senha(altearSenhaRequest $request){

        $request->validated();

        //dados enviados
        $nova_senha = trim($request->input('nova_senha'));
        $confirma_senha = trim($request->input('confirma_senha'));
        $senha_atual = trim($request->input('atual_senha'));
        $id_usuario = session('usuario')->id;
        

        if($nova_senha != $confirma_senha){
            $erro = ['erro' => 'Senha e confirmar senha nao correspondem.'];

            return view('alterar_senha', $erro);
        }
        $usuario = Usuario::find($id_usuario);
        if (!hash::check($senha_atual, $usuario->senha)) {
            $erro = ['erro' => 'Senha invalida'];
            return view('alterar_senha', $erro);
        }

        $usuario->senha = Hash::make($nova_senha);;
        $usuario->save();

        session()->put('usuario', $usuario);
        $alterado = ['alterado' => 'Senha alterada.'];
        return view('alterar_senha', $alterado);



    }

    //-------editar dados do usuario-----------------------

    public function editar_perfil(){
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        return view('editar_perfil');
    }
    

    public function editar_perfil_usuario(editarUsuarioRequest $request)

    {   //validar os dados recebidos do formulario
        $request->validated();

        //dados enviados
        $nome_usuario = trim($request->input('text_nome'));
        $email_usuario = trim($request->input('text_email'));
        $senha_usuario = trim($request->input('text_senha'));
        $id_usuario = session('usuario')->id;
        $email_atual = session('usuario')->email;

        $usuari = usuario::where('email', $email_usuario)->first();

        //verificar se o email ja estar cadastrado
        if($email_usuario != $email_atual){

            if ($usuari) {

                $erro = ['erro' => 'Email ja cadastrado.'];

                return view('editar_perfil', $erro);}
        }
        //comparar senhas
        $usuario = Usuario::find($id_usuario);
        if (!hash::check($senha_usuario, $usuario->senha)) {
            $erro = ['erro' => 'Senha invalida'];

            return view('editar_perfil', $erro);}


        //alterar os dados
        $usuario = Usuario::find($id_usuario);
        $usuario->nome = $nome_usuario;
        $usuario->email = $email_usuario;
        $usuario->save();

        //retorna a view com uma nova sessao com os dados alterados
        $usuari = Usuario::find($id_usuario);
        session()->put('usuario', $usuari);
        $alterado = ['alterado' => 'Dados alterados'];
        return view('editar_perfil', $alterado);
    
}

    
        //perguntar antes de apagar
        public function excluir_perfil(){
            if (!$this->checksessao()) {
                return redirect()->route('login');
            }
            $usuario = ['usuario'=> session('usuario')];
            $alerta = ['alerta' => 'Deseja realmente excluir a conta?'];
            return view('perfil', $alerta, $usuario);
        }
//----------excluir usuario e todos os seus dados-----
 /* */  public function excluir_conta()
    {
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        $id_usuario = session('usuario')->id;

        $usuario = usuario::find($id_usuario);
        $usuario->delete();

        $task = task::where('id_usuario', $id_usuario);
        $task->delete();


        session()->forget('usuario');


        return redirect()->route('login');
    }
}