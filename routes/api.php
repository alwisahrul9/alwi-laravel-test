<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
   // return $request->user();
   Route::prefix('company')->group(function () {
      Route::get('/', [CompanyController::class, 'index']); 
      Route::post('/', [CompanyController::class, 'store']); 
      Route::get('{id}', [CompanyController::class, 'show']);
      Route::post('{id}', [CompanyController::class, 'update']);
      Route::delete('{id}', [CompanyController::class, 'destroy']);
   });
   
   Route::prefix('employee')->group(function () {
      Route::get('/', [EmployeeController::class, 'index']); 
      Route::post('/', [EmployeeController::class, 'store']);
      Route::get('{id}', [EmployeeController::class, 'show']);
      Route::post('{id}', [EmployeeController::class, 'update']);
      Route::delete('{id}', [EmployeeController::class, 'destroy']);
   });

   Route::get('/logout', [LoginController::class, 'logout']);
});


Route::post('/login', [LoginController::class, 'login']);