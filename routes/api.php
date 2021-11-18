<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/getUsers', [UserController::class, 'getUsers'])->middleware(['isCheckHeader']);
Route::post('/save', [UserController::class, 'save'])->middleware(['isCheckHeader']);
Route::post('/update', [UserController::class, 'update'])->middleware(['isCheckHeader']);
Route::post('/delete', [UserController::class, 'delete'])->middleware(['isCheckHeader']);
