<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use App\Models\Workout;

class WorkoutPlanController extends Controller
{
    public function index()
{
    $workout = null;
    $workoutPlanImg = null;
    $days = null;
    $dayImagePath = null;
    $exerciseImagePath = null;

    if (Auth::check()) {
        $user = Auth::user();
        $workout = Workout::with('days.exerciseWorkout.exercise')->where('user_id', $user->id)->first();

        if ($workout) {
            $imageService = new ImageService();
            $workoutPlanImg = $imageService->getImagePath('workouts/user', $workout->workout_id, config('images.workouts.default'));
            $workout->imagePath = $workoutPlanImg;

            foreach ($workout->days as $day) {
                $dayImagePath = $imageService->getImagePath('workouts/user/days', $day->workout_day_id, config('images.days.default'));
                $day->daysImagePath = $dayImagePath;

                foreach ($day->exerciseWorkout as $exerciseWorkout) {
                    $exerciseImagePath = $imageService->getImagePath('exercises', $exerciseWorkout->exercise->exercise_id, config('images.exercises.default'));
                    $exerciseWorkout->exerciseImagePath = $exerciseImagePath;
                    $exerciseWorkout->exerciseName = $exerciseWorkout->exercise->exercise_name;
                    $exerciseWorkout->exerciseDescription = $exerciseWorkout->exercise->exercise_description;
                    $exerciseWorkout->exerciseType = $exerciseWorkout->exercise->exercise_type;
                    $exerciseWorkout->exerciseDifficulty = $exerciseWorkout->exercise->exercise_strength_level;
                }
            }
            $days = $workout->days;
        }
    }

    return view('users.viewWorkout', compact('workout', 'workoutPlanImg', 'days', 'dayImagePath', 'exerciseImagePath'));
}
}
