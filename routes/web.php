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
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\FamousWorkoutController;

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

    Route::get('/FamousWorkouts', [FamousWorkoutController::class, 'index'])->name('famousWorkouts');

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

        Route::get('/FamousWorkouts/{id}', [FamousWorkoutController::class, 'show'])->name('famousWorkout');
        Route::post('/FamousWorkouts/{id}', [FamousWorkoutController::class, 'store'])->name('copyFamousWorkout');

        Route::delete('/profile/deleteUser/{id}', [UserController::class, 'destroy'])->name('deleteUser');

        Route::post('/addWorkoutPlan', [WorkoutPlannerController::class, 'store'])->name('addWorkout');

        Route::post('/addExerciseToWorkout', [WorkoutPlannerController::class, 'addExercise'])->name('addExerciseToWorkout');
        Route::post('/addWorkoutDay', [WorkoutPlannerController::class, 'addWorkoutDay'])->name('addWorkoutDay');

        Route::get('/user/workoutPlan', [WorkoutPlanController::class, 'index'])->name('personalWorkoutPlan');
        Route::post('/user/updateWorkoutPlan/{id}', [WorkoutPlanController::class, 'updateWorkoutPlan'])->name('updateWorkoutPlan');
        Route::delete('/user/deleteWorkoutPlan/{id}', [WorkoutPlanController::class, 'destroyWorkoutPlan'])->name('deleteWorkoutPlan');
        Route::post('/user/updateWorkoutDay/{id}', [WorkoutPlanController::class, 'updateWorkoutDay'])->name('updateWorkoutDay');
        Route::delete('/user/deleteWorkoutDay/{id}', [WorkoutPlanController::class, 'destroyWorkoutDay'])->name('deleteWorkoutDay');
        Route::post('/user/updateWorkoutDayExercise/{id}', [WorkoutPlanController::class, 'updateWorkoutDayExercise'])->name('updateWorkoutDayExercise');
        Route::delete('/user/deleteWorkoutDayExercise/{id}', [WorkoutPlanController::class, 'destroyWorkoutDayExercise'])->name('deleteWorkoutDayExercise');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::post('/admin/updateUser/{id}', [AdminController::class, 'update'])->name('editUser');
        Route::delete('/admin/deleteUser/{id}', [AdminController::class, 'destroy'])->name('deleteUser');

        Route::get('/exercise', [ExerciseController::class, 'index'])->name('adminExercise');
        Route::post('/admin/addExercise', [ExerciseController::class, 'store'])->name('addExercise');
        Route::post('/admin/updateExercise/{id}', [ExerciseController::class, 'update'])->name('editExercise');
        Route::delete('/admin/deleteExercise/{id}', [ExerciseController::class, 'destroy'])->name('deleteExercise');

        Route::get('/workout', [WorkoutController::class, 'index'])->name('adminWorkout');
        Route::post('/admin/addWorkout', [WorkoutController::class, 'storePlan'])->name('addWorkoutPlan');
        Route::delete('/admin/deleteWorkout/{id}', [WorkoutController::class, 'destroyPlan'])->name('deleteWorkoutPlanAdmin');
        Route::get('/admin/updateWorkout/{id}', [WorkoutController::class, 'showUpdatePlan'])->name('showUpdateWorkoutPlanAdmin');
        Route::post('/admin/addWorkoutDay', [WorkoutController::class, 'storeDay'])->name('addWorkoutDayAdmin');
        Route::post('/admin/updateFamousWorkoutDay/{id}', [WorkoutController::class, 'updateFamousWorkoutDay'])->name('editFamousWorkoutDay');
        Route::delete('/admin/deleteFamousWorkoutDay/{id}', [WorkoutController::class, 'destroyFamousWorkoutDay'])->name('deleteFamousWorkoutDay');
        Route::post('/admin/updateFamousWorkoutDayExercise/{id}', [WorkoutController::class, 'updateFamousWorkoutDayExercise'])->name('editFamousWorkoutDayExercise');
        Route::delete('/admin/deleteFamousWorkoutDayExercise/{id}', [WorkoutController::class, 'destroyFamousWorkoutDayExercise'])->name('deleteFamousWorkoutDayExercise');
        Route::post('/admin/updateFamousWorkoutPlan/{id}', [WorkoutController::class, 'updateFamousWorkoutPlan'])->name('editFamousWorkoutPlan');
        Route::delete('/admin/deleteFamousWorkoutPlan/{id}', [WorkoutController::class, 'destroyFamousWorkoutPlan'])->name('deleteFamousWorkoutPlan');

        Route::get('/muscleGroup', [MuscleGroupController::class, 'index'])->name('adminMuscleGroup');
        Route::post('/admin/updateMuscleGroup/{id}', [MuscleGroupController::class, 'update'])->name('editMuscleGroup');
        Route::post('/admin/addMuscleGroup', [MuscleGroupController::class, 'store'])->name('addMuscleGroup');
        Route::delete('/admin/deleteMuscleGroup/{id}', [MuscleGroupController::class, 'destroy'])->name('deleteMuscleGroup');
    });
});
