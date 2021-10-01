<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard')->middleware('auth');

Route::middleware(['auth', 'is_active'])->group(function () {

    Route::get('/read-notifications/{notification}', function (DatabaseNotification $notification) {
        $notification->markAsRead();
        return back();
    })->name('readNotification');
    // user routes
    Route::delete('/users/deleteAll', [UserController::class, 'deleteAll'])->name('users.deleteAll');
    Route::delete('/users/{user}/deletePhoto', [UserController::class, 'destroyPhoto'])->name('user-photo.destroy');
    Route::get('/users/{user}/changeStatus', [UserController::class, 'changeStatus'])->name('user.changeStatus');
    Route::put('/users/changeStatus', [UserController::class, 'changeAllUsersStatus'])->name('users.changeStatus');
    Route::resource('users', UserController::class);

    // role routes
    Route::resource('roles', RoleController::class);

    // products routes
    Route::resource('shop', ProductController::class);
});
