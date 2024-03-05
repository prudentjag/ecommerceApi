<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\auth\AuthController;
use App\Http\Controllers\API\v1\cartController;
use App\Http\Controllers\API\v1\commentController;
use App\Http\Controllers\API\v1\PostController;
use App\Http\Controllers\API\v1\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);
 Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/users', [AuthController::class, 'getUsers'])->middleware('restrictRole:admin');
    Route::get('/users/{id}', [AuthController::class, 'getUser'])->middleware('restrictRole:admin');
    Route::delete('/deleteUser/{id}', [AuthController::class, 'deletUser'])->middleware('restrictRole:admin');
    Route::resource('product', ProductController::class)->middleware('restrictRole:admin');
    Route::resource('comment', commentController::class)->middleware('restrictRole:user');
    Route::resource('cart', cartController::class)->middleware('restrictRole:user');
    Route::get('/product', [ProductController::class, 'index'])->middleware('restrictRole:user,admin');

});

