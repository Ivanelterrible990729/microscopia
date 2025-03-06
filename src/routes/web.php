<?php

use App\Http\Controllers\ActivitylogController;
use App\Http\Controllers\CnnModelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\Facades\Route;

// WELCOME  ===================================================
// ============================================================

Route::get('/', [DashboardController::class, 'welcome']);

// INACTIVE PAGE  =============================================
// ============================================================

Route::get('inactive-page', [DashboardController::class, 'inactivePage'])->name('inactive-page');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    EnsureUserIsActive::class,
])->group(function () {

    // DASHBOARD  =================================================
    // ============================================================

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('admin')->group(function () {

        // ROLES  =====================================================
        // ============================================================

        Route::resource('role', RoleController::class)->except('create', 'edit', 'update');

        // USERS  =====================================================
        // ============================================================

        Route::post('user/{user}', [UserController::class, 'restore'])->name('user.restore')->withTrashed();
        Route::get('user/{user}/profile-photo/download', [UserController::class, 'downloadProfilePhoto'])->name('user.profile-photo.download');
        Route::get('user/{user}/personification/start', [UserController::class, 'startPersonification'])->name('user.personification.start');
        Route::get('user/personification/stop', [UserController::class, 'stopPersonification'])->name('user.personification.stop');
        Route::resource('user', UserController::class)->except('create', 'edit', 'update')->withTrashed(['show']);

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

    Route::get('/image/labeling', [ImageController::class, 'labeling'])->name('image.labeling');
    Route::get('/image/{image}/download', [ImageController::class, 'downloadImage'])->name('image.download');
    Route::resource('image', ImageController::class)->except('create', 'update', 'delete')->withTrashed(['show']);
});
