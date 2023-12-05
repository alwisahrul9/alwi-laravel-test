<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [PagesController::class, 'index'])->name('index')->middleware('auth');
Route::get('/details/{id}', [PagesController::class, 'details'])->name('details')->middleware('auth');
Route::get('/logoutProcess', [PagesController::class, 'logoutProcess'])->middleware('auth');

Route::get('/login', [PagesController::class, 'login'])->name('login')->middleware('guest');
Route::post('/loginProcess', [PagesController::class, 'loginProcess'])->middleware('guest');