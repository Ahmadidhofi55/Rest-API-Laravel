<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\api\v1\PostsController;
use App\Http\Resources\BlogResource;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

//route api list postingan
//Route::resource('/posts', PostsController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});*/

//Route api Blog with Laravel Santum
Route::middleware(['auth:sanctum'])->group(function () {
    //Route Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //Route Blog Resource
    Route::resource('/blog', BlogResource::class);

    //Route Post
    Route::resource('/posts', PostsController::class);
});

