<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\DatabaseSchemaService;
use App\Models\Exercise;
use App\Models\Workout;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;

class WorkoutPlannerController extends Controller
{
    public function index()
    {

        $workout = null;
        if (Auth::check()) {
            $user = Auth::user();
            $workout = $user->workout;
        }
        $columns = DatabaseSchemaService::getColumnNames('exercise');
        $items = Exercise::all();



        $workoutDifficulty = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workoutGoals = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workoutTypes = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workoutGenders = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');

        $imageService = new ImageService();
        foreach ($items as $item) {
            $item->imagePath = $imageService->getImagePath('exercises', $item->exercise_id, config('images.exercises.default'));
        }

        return view('workouts.workoutPlanner', compact('items', 'columns', 'workout', 'workoutDifficulty', 'workoutGoals', 'workoutTypes', 'workoutGenders'));
    }

}