<?php

namespace App\Http\Controllers\V1;

use App\Models\task;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\classes\enc;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;

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

   public function create(TaskRequest $request, TaskService $taskService)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }
      $taskService->createStudent($request);

      return redirect('home');

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

   
   public function update( TaskRequest $request, TaskService $taskService)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }
      
      $taskService->updeteTask($request);

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

   public function destroy($id, TaskService $taskService)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }
      
      $taskService->destroyTask($id);

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
