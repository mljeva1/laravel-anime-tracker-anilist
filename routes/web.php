<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
//Route::get('/user', [UserController::class, 'index'])->name('user.user');
Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.user');
    Route::put('/user/{id}', 'update')->name('user.update');
    Route::post('/user/update-avatar', [UserController::class, 'updateAvatar'])->name('user.update-avatar');
    Route::get('/user/refresh-avatars', [UserController::class, 'refreshAvatars'])->name('user.refresh-avatars');
});


Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

use App\Http\Controllers\AuthController;
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

use App\Http\Controllers\AnimeController;
Route::controller(AnimeController::class)->group(function () {
    Route::get('/', [AnimeController::class, 'topAnimeHome'])->name('home');
    Route::get('/anime', [AnimeController::class, 'index'])->name('anime');
});

use App\Http\Controllers\RoleController;
Route::get('/roles', [RoleController::class, 'roles'])->name('info.roles');