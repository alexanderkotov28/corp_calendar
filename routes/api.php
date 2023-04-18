<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->get('/auth/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::apiResource('users', UserController::class);

    Route::apiResource('departments', DepartmentController::class);

    Route::apiResource('events', EventController::class);
    Route::get('/events/{event}/participants', [EventController::class, 'participants'])->name('events.participants');
});
