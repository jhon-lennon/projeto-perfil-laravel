<?php

namespace App\Services;

use App\Models\task;

class TaskService
{
    public function __construct(protected Task $model)
    {
    }

    public function createStudent($request)
    {

        return $this->model->create([

            'tarefas' => $request->input('new_task'),
            'id_usuario' => session('usuario')->id,
            'concluido' => null
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
        if ($task = $this->model->where('id', $id)->exists()) {
            $task = $this->model->find($id);

            if ($task->id_usuario == session('usuario')->id) {
                $task->delete();

                return;
            }
        }
    }
}
