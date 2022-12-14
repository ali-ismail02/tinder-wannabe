<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController; 

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::post('signUp', [UserController::class, 'signUp']);

Route::group(["middleware" => "JWT"], function(){
    Route::post('favorite', [UserController::class, 'addOrRemoveFavorite']);
    Route::post('check-favorite', [UserController::class, 'checkIfFavorited']);
    Route::post('block', [UserController::class, 'addOrRemoveBlock']);
    Route::post('users', [UserController::class, 'displayUsers']);
    Route::post('search', [UserController::class, 'searchUsers']);
    Route::post('chats', [UserController::class, 'chats']);
    Route::post('messages', [UserController::class, 'chatAddorOpen']);
}); 