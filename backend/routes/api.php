<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users',  [\App\Http\Controllers\UserController::class, 'index']);
    Route::patch('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::put('/users/{id}',    [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    Route::get('/user', function (Request $r) {
        $user = $r->user()->load('role:id,name');

        return [
            'id'          => $user->id,
            'email'       => $user->email,
            'last_name'   => $user->last_name,
            'first_name'  => $user->first_name,
            'middle_name' => $user->middle_name,
            'role'        => $user->role ? ['id'=>$user->role->id,'name'=>$user->role->name] : null,
        ];
    });
});



