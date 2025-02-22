<?php

use App\Http\Controllers\ActivitylogController;
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


    Route::prefix('admin')->group(function () {

        // ROLES  =====================================================
        // ============================================================

        Route::resource('role', RoleController::class)->except('create', 'edit', 'update');

        // USERS  =====================================================
        // ============================================================

        // Route::resource('users', UserController::class)->except('create', 'edit', 'update')->withTrashed(['show']);

        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('user.show')->withTrashed();
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('users/{user}', [UserController::class, 'restore'])->name('user.restore')->withTrashed();
        Route::get('users/{user}/profile-photo/download', [UserController::class, 'downloadProfilePhoto'])->name('user.profile-photo.download');
        Route::get('users/{user}/personification/start', [UserController::class, 'startPersonification'])->name('user.personification.start');
        Route::get('users/personification/stop', [UserController::class, 'stopPersonification'])->name('user.personification.stop');

        // ACTIVITY LOG  ==============================================
        // ============================================================

        Route::get('acciones', [ActivitylogController::class, 'index'])->name('activitylog.index');
    });

    // CNN MODELS  ================================================
    // ============================================================

    Route::get('cnn-models/', [CnnModelController::class, 'index'])->name('cnn-model.index');
    Route::get('cnn-models/{cnnModel}', [CnnModelController::class, 'show'])->name('cnn-model.show');
    Route::delete('cnn-models/{cnnModel}', [CnnModelController::class, 'destroy'])->name('cnn-model.destroy');

    // IMAGES =====================================================
    // ============================================================

    Route::get('images', [ImageController::class, 'index'])->name('image.index');
    Route::get('/images/labeling', [ImageController::class, 'labeling'])->name('image.labeling');
    Route::get('images/{image}', [ImageController::class, 'show'])->name('image.show')->withTrashed();
    Route::get('images/{image}/edit', [ImageController::class, 'edit'])->name('image.edit');
});
