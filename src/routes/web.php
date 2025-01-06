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

    Route::get('admin/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('admin/roles/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::delete('admin/roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('admin/users', [UserController::class, 'index'])->name('user.index');
    Route::get('admin/users/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('admin/users/{user}/profile-photo/download', [UserController::class, 'downloadProfilePhoto'])->name('user.profile-photo.download');
    Route::get('admin/users/{user}/personification/start', [UserController::class, 'startPersonification'])->name('user.personification.start');
    Route::get('admin/users/personification/stop', [UserController::class, 'stopPersonification'])->name('user.personification.stop');
});
