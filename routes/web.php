<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//DEFINE LOGIN MANUALLY
Route::get('users/login/{user}', [\App\Http\Controllers\UserController::class, 'loginByUser']);


Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::middleware(['password.temporary'])->group(function () {   
        
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        //PROFILES
        Route::prefix('profiles')->group(function () {
            Route::post('active', [\App\Http\Controllers\ProfileController::class, 'active']);
            Route::get('list/filter/{name}', [\App\Http\Controllers\ProfileController::class, 'getListByName']);
            Route::post('list', [\App\Http\Controllers\ProfileController::class, 'getList']);
            Route::post('update-json', [\App\Http\Controllers\ProfileController::class, 'updateJson']);
        });
        Route::resource('profiles', \App\Http\Controllers\ProfileController::class);
        
        //USERS
        Route::prefix('users')->group(function () {
            Route::post('list', [\App\Http\Controllers\UserController::class, 'getList']);
            Route::get('list/filter/{name}', [\App\Http\Controllers\UserController::class, 'getListByName']);
            Route::post('active', [\App\Http\Controllers\UserController::class, 'active']);
            Route::post('update-json', [\App\Http\Controllers\UserController::class, 'updateJson']);
        });
        Route::resource('users', \App\Http\Controllers\UserController::class);

    });

    //USER PROFILE
    Route::prefix('user')->group(function () {
        Route::get('profile', [\App\Http\Controllers\UserController::class, 'profile']);
        Route::post('profile/save', [\App\Http\Controllers\UserController::class, 'saveProfile']);
    });
});