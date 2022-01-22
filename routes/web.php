<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\main;
use App\Http\Controllers\main2;

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
Route::get('/', [main::class,'index'])->name('index');
Route::get('/login', [main::class,'login'])->name('login');
Route::post('/frm_submit', [main::class,'frm_submit'])->name('frm_submit');
Route::get('/home', [main::class,'home'])->name('home');
Route::get('/logout', [main::class,'logout'])->name('logout');
Route::get('/editar_senha',[main::class,'editar_senha'])->name('editar_senha');
Route::post('/alterando_senha',[main::class,'alterando_senha'])->name('alterando_senha');


Route::get('/cadastro',[main::class, 'cadastro'])->name('cadastro');
Route::post('/cadastrar',[main::class, 'cadastrar'])->name('cadastrar');
Route::post('/editar_perfil_usuario',[main::class, 'editar_perfil_usuario'])->name('editar_perfil_usuario');
Route::get('/editar_perfil',[main::class,'editar_perfil'])->name('editar_perfil');
route::get('/excluir_perfil', [main::class, 'excluir_perfil'])->name('excluir_perfil');
//-------------tarefas------------------------

Route::get('/invisivel_tarefa',[main2::class, 'invisivel_tarefa'])->name('invisivel_tarefa');

route::get('/nova_tarefa',[main2::class, 'nova_tarefa'])->name('nova_tarefa');
route::post('/criar_tarefa',[main2::class, 'criar_tarefa'])->name('criar_tarefa');

Route::get('/visibilidade/{id}',[main2::class, 'visibilidade'])->name('visibilidade');
Route::get('/invisivel/{id}',[main2::class, 'invisivel'])->name('invisivel');

Route::get('/concluido/{id}',[main2::class, 'concluido'])->name('concluido');
Route::get('/afazer/{id}',[main2::class, 'afazer'])->name('afazer');

Route::get('/editar_tarefa/{id}',[main2::class, 'editar_tarefa'])->name('editar_tarefa');
route::post('/editar',[main2::class, 'editar'])->name('editar');

Route::get('/excluir_tarefa/{id}',[main2::class, 'excluir_tarefa'])->name('excluir_tarefa');
Route::get('/perfil',[main2::class, 'perfil'])->name('perfil');
Route::get('excluir_conta',[main::class, 'excluir_conta'])->name('excluir_conta');
