<?php

use App\Http\Controllers\LocalizationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\App;

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

Route::get('/localization/{locale}', LocalizationController::class)->name('localization');

Route::middleware('localization')->group(function () {
    //home page

Route::get('/', function () {
    return view('index');
});

//login page
Route::get('/login', function () {
    return view('login');
});

//show registerform
Route::get('/register', [UserController::class, 'create']);

//show login form
Route::get('/login', [UserController::class, 'login']);

//create new user
Route::post('/users', [UserController::class, 'store']);

//login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//logout user
Route::post('/logout', [UserController::class, 'logout']);

//show user profile
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [UserController::class, 'show']);

    //edit preferences
    Route::get('/profile/preference', [UserController::class, 'setPreference']);
});

});