<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RoleController;

// Я знаю, что есть apiResource, но таким образом я перестаю владеть кодом получая сразу "магически" модель User
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/{id}', 'show')->name('users.show');
    Route::patch('/users/{id}', 'update')->name('users.update');
    Route::post('/users', 'register')->name('users.register');
    Route::delete('/users/{id}', 'destroy')->name('users.destroy');
});

Route::controller(RoleController::class)->group(function () {
    Route::get('/roles', 'index')->name('roles.index');
    Route::post('/roles', 'create')->name('roles.create');
});
