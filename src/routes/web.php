<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users/{user}/profile-photo/download', [UserController::class, 'downloadProfilePhoto'])
        ->name('user.profile-photo.download');

    Route::get('admin/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('admin/roles/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::delete('admin/roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
});
