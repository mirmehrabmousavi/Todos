<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('/addTodos', [\App\Http\Controllers\HomeController::class, 'createTodo'])->name('addTodos');
    Route::post('/addTodos', [\App\Http\Controllers\HomeController::class, 'storeTodo'])->name('storeTodos');
    Route::get('/editTodos/{id}', [\App\Http\Controllers\HomeController::class, 'editTodo'])->name('editTodos');
    Route::patch('/editTodos/{id}', [\App\Http\Controllers\HomeController::class, 'updateTodo'])->name('updateTodos');
    Route::delete('/deleteTodos/{id}', [\App\Http\Controllers\HomeController::class, 'deleteTodo'])->name('deleteTodos');
});

Route::group(['middleware' => 'admin','auth'], function () {
    Route::get('/admin/home', [\App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
    Route::patch('/confirm/{id}', [App\Http\Controllers\HomeController::class, 'confirm'])->name('confirmTodo');
    Route::patch('/decline/{id}', [App\Http\Controllers\HomeController::class, 'decline'])->name('declineTodo');
    Route::patch('/confirmAll', [App\Http\Controllers\HomeController::class, 'confirmAll'])->name('confirmAll');
    Route::patch('/declineAll', [App\Http\Controllers\HomeController::class, 'declineAll'])->name('declineAll');
    Route::get('/filterDate', [App\Http\Controllers\HomeController::class, 'filterDate'])->name('filterDate');
});
