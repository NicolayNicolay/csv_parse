<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\RegisterController;
use Modules\Files\Controllers\FileController;
use Modules\Objects\Controllers\ObjectController;

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/checkAuth', [AuthController::class, 'getCurrentAuth'])->name('auth.currentAuth');
    // Административная часть сайта
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/register', [RegisterController::class, 'store'])
            ->name('admin.register.submit');
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        });
        Route::group(
            ['prefix' => 'objects'],
            static function () {
                Route::post('/list', [ObjectController::class, 'list'])->name('objects.list');
                Route::post('/store', [ObjectController::class, 'store'])->name('objects.store');
                Route::get('/remove/{id?}', [ObjectController::class, 'destroy'])->name('objects.destroy');
            }
        );
        Route::group(
            ['prefix' => 'files'],
            static function () {
                Route::post('/uploadFiles', [FileController::class, 'uploadFile'])->name('files.uploadFiles');
            }
        );
    });
})->middleware('auth');

Route::get('/{any}', fn() => view('spa'))
    ->where('any', '.*')
    ->name('spa');
