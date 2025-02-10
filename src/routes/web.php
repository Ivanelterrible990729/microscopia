<?php

use App\Http\Controllers\CnnModelController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// INACTIVE PAGE  =============================================
// ============================================================

Route::get('inactive-page', function () {
    return view('errors.inactive');
})->name('inactive-page');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    EnsureUserIsActive::class,
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ROLES  =====================================================
    // ============================================================

    Route::get('admin/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('admin/roles/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::delete('admin/roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    // USERS  =====================================================
    // ============================================================

    Route::get('admin/users', [UserController::class, 'index'])->name('user.index');
    Route::get('admin/users/{user}', [UserController::class, 'show'])->name('user.show')->withTrashed();
    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('admin/users/{user}', [UserController::class, 'restore'])->name('user.restore')->withTrashed();
    Route::get('admin/users/{user}/profile-photo/download', [UserController::class, 'downloadProfilePhoto'])->name('user.profile-photo.download');
    Route::get('admin/users/{user}/personification/start', [UserController::class, 'startPersonification'])->name('user.personification.start');
    Route::get('admin/users/personification/stop', [UserController::class, 'stopPersonification'])->name('user.personification.stop');

    // CNN MODELS  ================================================
    // ============================================================

    Route::get('admin/cnn-models/', [CnnModelController::class, 'index'])->name('cnn-model.index');
    Route::get('admin/cnn-models/{cnnModel}', [CnnModelController::class, 'show'])->name('cnn-model.show');
    Route::delete('admin/cnn-models/{cnnModel}', [CnnModelController::class, 'destroy'])->name('cnn-model.destroy');

    // IMAGES =====================================================
    // ============================================================

    Route::get('images', [ImageController::class, 'index'])->name('image.index');
    Route::get('/images/labeling', [ImageController::class, 'labeling'])->name('image.labeling');
    Route::get('images/{image}', [ImageController::class, 'show'])->name('image.show')->withTrashed();
    Route::get('images/{image}/edit', [ImageController::class, 'edit'])->name('image.edit');
});
