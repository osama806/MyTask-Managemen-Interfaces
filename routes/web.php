<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
        Route::post('tasks/{id}/delivery', [TaskController::class, 'taskDelivery'])->name('delivery');
        Route::resource('tasks', TaskController::class)->except(['show']);
    });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
