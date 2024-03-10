<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;

// Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
//     return $request->user();
// });

Route::post('login',[AuthController::class,'login']);
Route::get('profile',[AuthController::class,'profile'])->middleware('auth:sanctum');
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::resource('companies', CompanyController::class)->middleware('auth:sanctum');
Route::resource('employees', EmployeeController::class)->middleware('auth:sanctum');
Route::get('companies-all',[CompanyController::class,'allCompanies'])->middleware('auth:sanctum');

