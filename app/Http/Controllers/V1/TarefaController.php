<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;

class TarefaController extends Controller
{

   public function __construct(private TaskService $taskService)
   {
   }

   public function index(TaskService $taskService)
   {
      return view('home', ['tarefa' => $taskService->allTasksUser()]);
   }

   public function showsTasksInvisible()
   {
      return view('home', ['tarefa' => $this->taskService->allTasksInvisibleUser()]);
   }

   public function create()
   {
      return view('nova_tarefa');
   }

   public function store(TaskRequest $request)
   {
      $this->taskService->createTask($request);

      return redirect('home');
   }

   public function edit($id)
   {
      $tarefa = $this->taskService->getTask($id);

      if ($tarefa) {
         return view('editar_tarefa', ['tarefa' => $tarefa]);
      } else {
         return redirect()->route('home');
      }
   }

   public function update(TaskRequest $request)
   {
      $this->taskService->updeteTask($request);

      return redirect()->route('home');
   }

   public function destroy($id)
   {
      $this->taskService->destroyTask($id);

      return redirect()->route('home');
   }

   public function changeVisibility($id)
   {
      $this->taskService->changeVisibilityTask($id);

      return redirect()->route('home');
   }

   public function changeStatus($id)
   {
      $this->taskService->changeStatusTask($id);

      return redirect()->route('home');
   }
}
