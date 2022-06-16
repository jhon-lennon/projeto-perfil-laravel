<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    protected $table = 'task';
    use HasFactory;

    protected $fillable = [
        'tarefas',
        'id_usuario',
        'concluido',
        'visivel',
        'created_at',
        'updated_at'
    ];
}
