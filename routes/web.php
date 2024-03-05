<?php

use App\Http\Controllers\LocalizationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Localization;
use App\Models\Preference;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\WorkoutPlannerController;

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

//show register form
Route::get('/register', [UserController::class, 'create']);

//show login form
Route::get('/login', [UserController::class, 'login'])->name('login');

//show workout planner
Route::get('/WorkoutPlanner', [WorkoutPlannerController::class, 'show']);

//create new user
Route::post('/users', [UserController::class, 'store']);

//login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::group(['middleware' => 'auth'], function () {

    //logout user
    Route::post('/logout', [UserController::class, 'logout']);

    //show user profile
    Route::get('/profile', [UserController::class, 'show']);

    //update user preference
    Route::post('/profile/updatePreference/{id}', [PreferenceController::class, 'update']);

    Route::post('/profile/updateGender/{id}', [UserController::class, 'updateGender']);

    //update user details
    Route::post('/profile/updateDetails/{id}', [UserController::class, 'updateDetails']);

    //update user credentials
    Route::post('/profile/updateCredentials/{id}', [UserController::class, 'updateCredentials']);

});

});