<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\TaskController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('send.message');
Route::get('/get-message/{toId}', [MessageController::class, 'getMessage'])->name('get.message');
Route::get('/check-user-active-status/{id}', [MessageController::class, 'checkUserStatus'])->name('check.user.status');
