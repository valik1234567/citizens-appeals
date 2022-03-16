<?php

use App\Http\Controllers\Api\AppealController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::post('categories/{id}',[CategoryController::class, 'update']);
Route::delete('categories/{id}',[CategoryController::class, 'delete']);

Route::get('appeals', [AppealController::class, 'index']);
Route::get('appeals/{id}', [AppealController::class, 'show']);
Route::post('appeals', [AppealController::class, 'store']);
Route::post('appeals/{id}',[AppealController::class, 'update']);
Route::delete('appeals/{id}',[AppealController::class, 'delete']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::post('users/{user}',[UserController::class, 'update']);
Route::delete('users/{user}',[UserController::class, 'delete']);
