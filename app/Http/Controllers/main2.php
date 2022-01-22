<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use App\Models\tarefas;
use App\Models\task;
use DateTime;
use Illuminate\Http\Request;
use Usuarios;

class main2 extends Controller
{
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

      $tarefa = new task();
      $tarefa->tarefas = $texto;
      $tarefa->id_usuario = $id;
      $tarefa->concluido = null;
      $tarefa->save();

      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return view('home', ['tarefa' => $tarefa]);
   }
   public function visibilidade($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }



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


      $tarefa = task::find($id);
      $tarefa->visivel = 1;
      $tarefa->save();
      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return view('home', ['tarefa' => $tarefa]);
   }

   public function concluido($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }



      $tarefa = task::find($id);
      $tarefa->concluido =  new DateTime();
      $tarefa->save();

      $id = session()->get('usuario')->id;

      $tarefa = task::where('id_usuario', $id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();

      return view('home', ['tarefa' => $tarefa]);
   }
   public function afazer($id)
   {
      if (!$this->checksessao()) {
         return redirect()->route('login');
      }



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
