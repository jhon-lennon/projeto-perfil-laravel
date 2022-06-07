<?php

namespace App\Http\Controllers\V1;

use App\Models\task;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\classes\enc;

class TarefaController extends Controller
{

   public function __construct(private enc $enc){}
   
   //-----usar para encriptar-----
   public function encriptar($valor)
   {
      return bin2hex(openssl_encrypt($valor, 'aes-256-cbc', '4Hzxso5WHSxMYA93flJ14R6qtd0HftKF', OPENSSL_RAW_DATA, 'p4Sml4pAdinhB384'));
   }

   //-----usar para densencriptar--
   public function desencriptar($valor_enc)
   {
      return openssl_decrypt(hex2bin($valor_enc), 'aes-256-cbc', '4Hzxso5WHSxMYA93flJ14R6qtd0HftKF', OPENSSL_RAW_DATA, 'p4Sml4pAdinhB384');
   }

   public function home()
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return view('home', ['tarefa' => $tarefa]);
   }

   public function nova_tarefa()
   {

      return view('nova_tarefa');
   }

   public function criar_tarefa(Request $request)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $texto = $request->input('nova_tarefa');
      $id = session()->get('usuario')->id;

      task::create([

         'tarefas' => $texto,
         'id_usuario' => $id,
         'concluido' => null
      ]);

      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return view('home', ['tarefa' => $tarefa]);
   }
   public function visibilidade($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

     // $desencriptar = new enc();
      $id = $this->enc->desencriptar($id);

      $tarefa = task::find($id);
      $tarefa->visivel = 0;
      $tarefa->save();
      return redirect()->route('home');
   }

   public function invisivel($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }
      $id = $this->desencriptar($id);

      $tarefa = task::find($id);
      $tarefa->visivel = 1;
      $tarefa->save();
      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return redirect()->route('home');
   }

   public function concluido($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $id = $this->desencriptar($id);

      $tarefa = task::find($id);
      $tarefa->concluido =  new DateTime();
      $tarefa->save();

      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return redirect()->route('home');
   }
   public function afazer($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $id = $this->desencriptar($id);

      $tarefa = task::find($id);
      $tarefa->concluido = null;
      $tarefa->save();
      return redirect()->route('home');
   }


   public function editar_tarefa($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $id = $this->desencriptar($id);

      $tarefa = task::find($id);


      return view('editar_tarefa', ['tarefa' => $tarefa]);
   }

   
   public function editar(Request $request)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $id = $request->input('id_tarefa');
      $id_usuario = session()->get('usuario')->id;

      $tarefa = task::find($id);
      $texto = $request->input('editar_tarefa');

      $tarefa->tarefas = $texto;
      $tarefa->id_usuario = $id_usuario;
      $tarefa->save();
      return redirect()->route('home');
   }


   public function invisivel_tarefa()
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 0)->orderBy('created_at', 'desc')->get();

      return view('home', ['tarefa' => $tarefa]);
   }

   public function excluir_tarefa($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }
      $id = $this->desencriptar($id);

      $tarefa = task::find($id);
      $tarefa->delete();

      return redirect()->route('home');
   }

   private function checksessao()
   {
      return session()->has('usuario');
   }

   public function perfil()
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }

      $usuario = session('usuario');
      return view('perfil', ['usuario' => $usuario]);
   }
}
