<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('index');
});

//login page
Route::get('/login', function () {
    return view('login');
});

//show register/create form
Route::get('/register', [UserController::class, 'create']);

//show login form
Route::get('/login', [UserController::class, 'login']);

//create new user
Route::post('/users', [UserController::class, 'store']);

//login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

