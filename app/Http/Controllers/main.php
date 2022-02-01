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
use App\Http\Requests\recuperarSenhaRequest;
use App\Mail\token;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class main extends Controller
{
    // usar pra verificar se existe sessao 
    private function checksessao()
    {
        return session()->has('usuario');
    }
    private function checksessaotoken()
    {
        return session()->has('token');
    }

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
    //============================================================ LOGIN ========================================================
    // chamar view login se nao estiver logado
    public function login()
    {
        if ($this->checksessao()) {
            return redirect()->route('index');
        }
        return view('login');
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

            $erro = ['erro' => 'O usuario não existe.'];
            return view('login', $erro);
        }

        // verificar a senha
        if (!hash::check($senha, $usuari->senha)) {
            $erro = ['erro_senha' => 'Senha incorreta.'];
            return view('login', $erro);
        }
        
        // iniciar a sesao e ir para o home
        session()->put('usuario', $usuari);
        $usuario = session('usuario')->email;
        Log::channel('Registro_log')->info('Usuario '.$usuario.', fez um login');

        return redirect()->route('index');
    }
    //==============================================================================================================================

    //=========================================================DESLOGAR============================================================
    //-----encerrar a sessao do usuario-----
    public function logout()
    {
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        $usuario = session('usuario')->email;

        Log::channel('Registro_log')->info('Usuario '.$usuario.' saiu');
        session()->forget('usuario');
        return redirect()->route('index');
    }
    //=============================================================================================================================

    //======================================================== CADASTRAR UM USUARIO ===============================================
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

        //enviar token para o email
        $token = random_int(100000, 999999);

        Mail::to($email_usuario)->send(new token($nome_usuario, $token));
        $senha = Hash::make($senha_usuario);

        //guardando informaçoes na sessao temporaria
        $new_user = [
            'nome' => $nome_usuario,
            'email' => $email_usuario,
            'senha' => $senha,
            'token' => $token
        ];
        $request->session()->put($new_user);

        if (!$this->checksessaotoken()) {
            return redirect()->route('login');
        }
        return view('comfirma_token');
    }

    //------------recebendo token -----------------
    public function confirmar_token(Request $request)
    {
        //verificar se existe sessao token
        if (!$this->checksessaotoken()) {
            return redirect()->route('login');
        }

        //verificar se ja existe sessao
        if ($this->checksessao()) {
            return redirect()->route('index');
        }

        $token = trim($request->input('frm_token'));

        if ($token != session('token')) {

            $erro = ['erro' => 'Codigo de verificação invalido.'];
            return view('comfirma_token', $erro);
        } else {
            //cadastrando usuario
            $usuario = new Usuario;
            $usuario->nome = session('nome');
            $usuario->email = session('email');
            $usuario->senha = session('senha');
            $usuario->save();

            //limpando sessao temporara
            session()->forget('nome');
            session()->forget('email');
            session()->forget('senha');
            session()->forget('token');

            $mensagem = ['mensagem' => 'Cadastrado. Faça o login para entrar.'];

            return view('login', $mensagem);
        }
    }
    //================================================================================================================================

    //============================================================== ALTERAR A SENHA ==================================================
    //--------chamar a view -------------------------------
    public function editar_senha()
    {
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        return view('alterar_senha');
    }
    //------alterar senha do usuario-----------------------
    public function alterando_senha(altearSenhaRequest $request)
    {

        $request->validated();

        //dados enviados sem espaços
        $nova_senha = trim($request->input('nova_senha'));
        $confirma_senha = trim($request->input('confirma_senha'));
        $senha_atual = trim($request->input('atual_senha'));
        $id_usuario = session('usuario')->id;

        //verificar se senha e confirmar senha corresponde
        if ($nova_senha != $confirma_senha) {
            $erro = ['erro' => 'Senha e confirmar senha nao correspondem.'];

            return view('alterar_senha', $erro);
        }

        //verificar se a senha atual estar correta
        $usuario = Usuario::find($id_usuario);
        if (!hash::check($senha_atual, $usuario->senha)) {
            $erro = ['erro' => 'Senha invalida'];
            return view('alterar_senha', $erro);
        }
        //salvando nova senha
        $usuario->senha = Hash::make($nova_senha);
        $usuario->save();

        session()->put('usuario', $usuario);
        $alterado = ['alterado' => 'Senha alterada.'];
        return view('alterar_senha', $alterado);
    }
    //===========================================================================================================================

    //==================================================RECUPERER SENHA==========================================================


    //---verificar se existe sessao e chamar view de formulario--
    public function recuperar_senha()
    {
        if ($this->checksessao()) {
            return redirect()->route('index');
        }
        return view('recuperar_senha.frm_email');
    }

    public function recuperar_senha_frm(Request $request)
    {

        $email_usuario = trim($request->input('text_email'));

        $usuari = usuario::where('email', $email_usuario)->first();

        //verificar se o email ja estar cadastrado
        if (!$usuari) {

            $erro = ['erro' => 'Email não cadastrado.'];

            return view('recuperar_senha.frm_email', $erro);
        }

        //enviar token para o email
        $token = random_int(100000, 999999);
        $nome_usuario = $usuari->nome;

        Mail::to($email_usuario)->send(new token($nome_usuario, $token));

        //guardando informaçoes na sessao temporaria
        $recuperar = [
            'nome' => $nome_usuario,
            'email' => $email_usuario,
            'token' => $token
        ];
        $request->session()->put($recuperar);


        return view('recuperar_senha.comfirma_token');
    }
    //recebendo token 
    public function recuperar_senha_token(Request $request)
    {
        //verificar se existe sessao token
        if (!$this->checksessaotoken()) {
            return redirect()->route('login');
        }

        //verificar se ja existe sessao
        if ($this->checksessao()) {
            return redirect()->route('index');
        }

        $token = trim($request->input('frm_token'));
        //verificar se token esta correto
        if ($token != session('token')) {

            $erro = ['erro' => 'Codigo de verificação invalido.'];
            return view('recuperar_senha.comfirma_token', $erro);
        }

        return view('recuperar_senha.nova_senha');
    }


    public function recuperando_senha(Request $request)
    {

        //dados recebidos
        $nova_senha = trim($request->input('nova_senha'));
        $confirma_senha = trim($request->input('confirma_senha'));
        $email_usuario = session('email');

        //verificar se a senha tem 8 ou mais caracter
        if (strlen($nova_senha) < 8 || strlen($confirma_senha) < 8) {
            $erro = ['erro' => 'A nova senha e cofirmar senha devem ter no minimo 8 caracter'];
            return view('recuperar_senha.nova_senha', $erro);
        }



        //verificar se senha e confirmar senha corresponde
        if ($nova_senha != $confirma_senha) {
            $erro = ['erro' => 'Senha e confirmar senha nao correspondem.'];

            return view('recuperar_senha.nova_senha', $erro);
        } else {


            $usuario = usuario::where('email', $email_usuario)->first();

            //salvando nova senha
            $usuario->senha = Hash::make($nova_senha);
            $usuario->save();


            //limpando sessao temporara
            session()->forget('nome');
            session()->forget('email');
            session()->forget('token');

            $mensagem = ['mensagem' => 'Senha recuperada. Faça o login para entrar.'];

            return view('login', $mensagem);
        }
    }

    //=============================================================================================================================

    //========================================================= EDITAR DADOS DO USUARIO =======================================================
    //-------chamar a view----------
    public function editar_perfil()
    {
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        return view('editar_perfil');
    }

    //-----------------------rcebendo dados----------------------------
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
        if ($email_usuario != $email_atual) {

            if ($usuari) {

                $erro = ['erro' => 'Email ja cadastrado.'];

                return view('editar_perfil', $erro);
            }
        }
        //comparar senhas
        $usuario = Usuario::find($id_usuario);
        if (!hash::check($senha_usuario, $usuario->senha)) {
            $erro = ['erro' => 'Senha invalida'];

            return view('editar_perfil', $erro);
        }


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
    //================================================================================================================================

    //======================================================EXCLUIR CONTA============================================================
    //perguntar antes de apagar
    public function excluir_perfil()
    {
        if (!$this->checksessao()) {
            return redirect()->route('login');
        }
        $usuario = ['usuario' => session('usuario')];
        $alerta = ['alerta' => 'Deseja realmente excluir a conta?'];
        return view('perfil', $alerta, $usuario);
    }
    //----------excluir usuario e todos os seus dados-----
    public function excluir_conta()
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
    //=============================================================================================================================== 
}
