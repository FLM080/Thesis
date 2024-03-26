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
use App\Http\Controllers\AdminController;
use App\Models\MuscleGroup;
use App\Http\Controllers\MuscleGroupController;
use App\Models\Exercise;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;

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
    })->name('home');

    //show register form
    Route::get('/register', [UserController::class, 'create'])->name('register');

    //show login form
    Route::get('/login', [UserController::class, 'login'])->name('login');

    //show workout planner
    Route::get('/WorkoutPlanner', [WorkoutPlannerController::class, 'index'])->name('workoutPlanner');

    //create new user
    Route::post('/createUser', [UserController::class, 'store'])->name('createUser');

    //login user
    Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('loginUser');

    Route::post('/saveExercise', [WorkoutController::class, 'store'])->name('saveExercise');

    Route::group(['middleware' => 'auth'], function () {
        //logout user
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');

        //show user profile
        Route::get('/profile', [UserController::class, 'index'])->name('profile');

        //update user preference
        Route::post('/profile/updatePreference/{id}', [PreferenceController::class, 'update'])->name('updatePreference');

        Route::post('/profile/updateGender/{id}', [UserController::class, 'updateGender'])->name('updateGender');

        //update user details
        Route::post('/profile/updateDetails/{id}', [UserController::class, 'updateDetails'])->name('updateDetails');

        //update user credentials
        Route::post('/profile/updateCredentials/{id}', [UserController::class, 'updateCredentials'])->name('updateCredentials');

        Route::delete('/profile/deleteUser/{id}', [UserController::class, 'destroy'])->name('deleteUser');

        Route::post('/addWorkoutPlan', [WorkoutPlannerController::class, 'store'])->name('addWorkout');

        Route::post('/addExerciseToWorkout', [WorkoutPlannerController::class, 'addExercise'])->name('addExerciseToWorkout');

        Route::post('/addWorkoutDay', [WorkoutPlannerController::class, 'addWorkoutDay'])->name('addWorkoutDay');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::post('/admin/editUser/{id}', [AdminController::class, 'update'])->name('editUser');
        Route::delete('/admin/deleteUser/{id}', [AdminController::class, 'destroy'])->name('deleteUser');

        Route::get('/exercise', [ExerciseController::class, 'index'])->name('adminExercise');
        Route::post('/admin/addExercise', [ExerciseController::class, 'store'])->name('addExercise');
        Route::post('/admin/editExercise/{id}', [ExerciseController::class, 'update'])->name('editExercise');
        Route::delete('/admin/deleteExercise/{id}', [ExerciseController::class, 'destroy'])->name('deleteExercise');
        
        Route::get('/workout', [AdminController::class, 'workout'])->name('adminWorkout');

        Route::get('/muscleGroup', [MuscleGroupController::class, 'index'])->name('adminMuscleGroup');
        Route::post('/admin/editMuscleGroup/{id}', [MuscleGroupController::class, 'update'])->name('editMuscleGroup');
        Route::post('/admin/addMuscleGroup', [MuscleGroupController::class, 'store'])->name('addMuscleGroup');
        Route::delete('/admin/deleteMuscleGroup/{id}', [MuscleGroupController::class, 'destroy'])->name('deleteMuscleGroup');
    });
});