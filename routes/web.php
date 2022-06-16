<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\{
    TarefaController,
    MainController
};

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/login', [MainController::class, 'login'])->name('login');
Route::post('/frm_submit', [MainController::class, 'frm_submit'])->name('frm_submit');
Route::get('/home', [MainController::class, 'home'])->name('home');
Route::get('/logout', [MainController::class, 'logout'])->name('logout');
Route::get('/editar_senha', [MainController::class, 'editar_senha'])->name('editar_senha');
Route::post('/alterando_senha', [MainController::class, 'alterando_senha'])->name('alterando_senha');


Route::get('/cadastro', [MainController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastrar', [MainController::class, 'cadastrar'])->name('cadastrar');
Route::post('/confirmar_token', [MainController::class, 'confirmar_token'])->name('confirmar_token');
Route::post('/editar_perfil_usuario', [MainController::class, 'editar_perfil_usuario'])->name('editar_perfil_usuario');
Route::get('/editar_perfil', [MainController::class, 'editar_perfil'])->name('editar_perfil');
route::get('/excluir_perfil', [MainController::class, 'excluir_perfil'])->name('excluir_perfil');
route::get('/recuperar_senha', [MainController::class, 'recuperar_senha'])->name('recuperar_senha');
Route::post('/recuperar_senha_frm', [MainController::class, 'recuperar_senha_frm'])->name('recuperar_senha_frm');
Route::post('/recuperar_senha_token', [MainController::class, 'recuperar_senha_token'])->name('recuperar_senha_token');
Route::post('/recuperando_senha', [MainController::class, 'recuperando_senha'])->name('recuperando_senha');
Route::get('/excluir_conta', [MainController::class, 'excluir_conta'])->name('excluir_conta');
Route::get('/perfil', [MainController::class, 'perfil'])->name('perfil');
//-------------tarefas------------------------






Route::prefix('tarefa')->middleware(['chekSession'])->group(function () {

    Route::get('/', [MainController::class, 'index'])->name('tarefaIndex');
    route::get('/create', [TarefaController::class, 'create'])->name('tarefaCreate');
    route::post('/store', [TarefaController::class, 'store'])->name('tarefaStore');
    Route::get('/edit/{id}', [TarefaController::class, 'edit'])->name('tarefaEdit');
    route::post('/update', [TarefaController::class, 'update'])->name('tarefaUpdate');
    Route::get('/delete/{id}', [TarefaController::class, 'destroy'])->name('tarefaDelete');
    Route::get('/changeVisibility/{id}', [TarefaController::class, 'changeVisibility'])->name('tarefaChangeVisibility');
    Route::get('/changeStatus/{id}', [TarefaController::class, 'changeStatus'])->name('tarefaChangeStatus');
    Route::get('/tasksInvisible', [TarefaController::class, 'showsTasksInvisible'])->name('tarefaTasksInvisible');
});
