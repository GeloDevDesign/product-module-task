<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\ProductController;

Route::middleware(['auth.admin'/* , 'XSS' */])
    ->name('admin.')
    ->prefix('admin')
    ->namespace('App\Http\Controllers\Admin')->group(function () {

        Route::get('/', 'DashboardController@index')->name('index');

        Route::group(['prefix' => 'backups'], function () {
            Route::get('/', 'BackupController@index')->name('backups.index');
            Route::get('download-backup', 'BackupController@downloadBackup')->name('backups.download-backup');
            Route::delete('delete-backup', 'BackupController@deleteBackup')->name('backups.delete-backup');
            Route::get('generate-db-backup', 'BackupController@generateDatabaseBackup')->name('backups.generate-db-backup');
            Route::get('generate-full-backup', 'BackupController@generateFullBackup')->name('backups.generate-full-backup');
        });

        Route::get('audit-logs', [ActivityLogController::class, 'index'])->name('audit-logs.index');

        Route::get('users/change-password/{user}', [UserController::class, 'changePassword'])->name('users.change-password')->middleware('auth.adminonly');
        Route::put('users/update-password/{user}', [UserController::class, 'updatePassword'])->name('users.update-password')->middleware('auth.adminonly');

        Route::get('profile/edit-profile', [ProfileController::class, 'editProfile'])->name('profile.edit-profile');
        Route::get('profile/update-profile', [ProfileController::class, 'update'])->name('profile.update-profile');
        Route::get('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::put('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

        Route::resource('users', UserController::class)->middleware('auth.adminonly');
        Route::resource('general-settings', GeneralSettingsController::class)->middleware('auth.adminonly');
        Route::resource('profile', ProfileController::class);



        // PRODUCT ROUTES

        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('products/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
