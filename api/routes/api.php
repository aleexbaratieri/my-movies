<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh',  'refresh');
        Route::get('me', 'me');
    });

    Route::prefix('movies')->controller(MovieController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{movieId}', 'show');
        Route::post('favorite', 'markAsfavorite');
        Route::post('watched', 'markAsWatched');
        Route::post('watch-later', 'markAsWatchLater');

        Route::delete('{movie}/favorite', 'unmarkAsfavorite');
        Route::delete('{movie}/watched', 'unmarkAsWatched');
        Route::delete('{movie}/watch-later', 'unmarkAsWatchLater');
    });
});
