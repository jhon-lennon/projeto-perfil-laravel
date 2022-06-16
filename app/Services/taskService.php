<?php

namespace App\Services;

use App\Models\task;
use DateTime;

class TaskService
{
    public function __construct(protected Task $model)
    {
    }

    public function allTasksUser()
    {
        return $this->model->where('id_usuario', session('usuario')->id)->where('visivel', 1)->orderBy('created_at', 'desc')->get();
    }

    public function allTasksInvisibleUser()
    {
        return $this->model->where('id_usuario', session('usuario')->id)->where('visivel', 0)->orderBy('created_at', 'desc')->get();
    }

    public function getTask($id)
    {

        if ($this->model->where('id', $id)->where('id_usuario', session('usuario')->id)->exists()) {
            return $this->model->find($id);
        } else {
            return false;
        }
    }

    public function createTask($request)
    {

        return $this->model->create([

            'tarefas' => $request->input('text_task'),
            'visivel' => 0,
            'concluido' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'id_usuario' => session('usuario')->id,

        ]);
    }

    public function updeteTask($request)
    {
        if ($task = $this->model->where('id', $request->input('id_task'))->exists()) {
            $task = $this->model->find($request->input('id_task'));

            if ($task->id_usuario == session('usuario')->id) {
                $task->tarefas = $request->input('text_task');
                $task->save();

                return;
            }
        }
    }

    public function destroyTask($id)
    {
        if ($this->model->where('id', $id)->where('id_usuario', session('usuario')->id)->exists()) {

            $task = $this->model->find($id);
            $task->delete();

            return;
        }
    }

    public function changeVisibilityTask($id){

        if ($this->model->where('id', $id)->where('id_usuario', session('usuario')->id)->exists()) {

            $task = $this->model->find($id);
            $task->visivel == 0 ? $task->visivel = 1 : $task->visivel = 0;
            $task->save();

            return;
        }
        
    }

    public function changeStatusTask($id){

        if ($this->model->where('id', $id)->where('id_usuario', session('usuario')->id)->exists()) {

            $task = $this->model->find($id);
            $task->concluido == 0 ? $task->concluido = 1 : $task->concluido = 0;
            $task->save();

            return;
        }
        
    }
}
