<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\{
    TarefaController,
    MainController
};



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [MainController::class,'index'])->name('index');
Route::get('/login', [MainController::class,'login'])->name('login');
Route::post('/frm_submit', [MainController::class,'frm_submit'])->name('frm_submit');
Route::get('/home', [MainController::class,'home'])->name('home');
Route::get('/logout', [MainController::class,'logout'])->name('logout');
Route::get('/editar_senha',[MainController::class,'editar_senha'])->name('editar_senha');
Route::post('/alterando_senha',[MainController::class,'alterando_senha'])->name('alterando_senha');


Route::get('/cadastro',[MainController::class, 'cadastro'])->name('cadastro');
Route::post('/cadastrar',[MainController::class, 'cadastrar'])->name('cadastrar');
Route::post('/confirmar_token',[MainController::class , 'confirmar_token'])->name('confirmar_token');
Route::post('/editar_perfil_usuario',[MainController::class, 'editar_perfil_usuario'])->name('editar_perfil_usuario');
Route::get('/editar_perfil',[MainController::class,'editar_perfil'])->name('editar_perfil');
route::get('/excluir_perfil', [MainController::class, 'excluir_perfil'])->name('excluir_perfil');
route::get('/recuperar_senha', [MainController::class, 'recuperar_senha'])->name('recuperar_senha');
Route::post('/recuperar_senha_frm',[MainController::class, 'recuperar_senha_frm'])->name('recuperar_senha_frm');
Route::post('/recuperar_senha_token',[MainController::class, 'recuperar_senha_token'])->name('recuperar_senha_token');
Route::post('/recuperando_senha',[MainController::class, 'recuperando_senha'])->name('recuperando_senha');
Route::get('excluir_conta',[MainController::class, 'excluir_conta'])->name('excluir_conta');

//-------------tarefas------------------------

Route::get('/invisivel_tarefa',[TarefaController::class, 'invisivel_tarefa'])->name('invisivel_tarefa');

route::get('/nova_tarefa',[TarefaController::class, 'nova_tarefa'])->name('nova_tarefa');
route::post('/criar_tarefa',[TarefaController::class, 'criar_tarefa'])->name('criar_tarefa');

Route::get('/visibilidade/{id}',[TarefaController::class, 'visibilidade'])->name('visibilidade');
Route::get('/invisivel/{id}',[TarefaController::class, 'invisivel'])->name('invisivel');

Route::get('/concluido/{id}',[TarefaController::class, 'concluido'])->name('concluido');
Route::get('/afazer/{id}',[TarefaController::class, 'afazer'])->name('afazer');

Route::get('/editar_tarefa/{id}',[TarefaController::class, 'editar_tarefa'])->name('editar_tarefa');
route::post('/editar',[TarefaController::class, 'editar'])->name('editar');

Route::get('/excluir_tarefa/{id}',[TarefaController::class, 'excluir_tarefa'])->name('excluir_tarefa');
Route::get('/perfil',[TarefaController::class, 'perfil'])->name('perfil');

