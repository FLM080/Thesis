<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\workout;
use App\Services\ImageService;
use App\Services\DatabaseSchemaService;
use Illuminate\Support\Facades\Auth;

class FamousWorkoutController extends Controller
{
    public function index()
    {
        $famousWorkouts = Workout::where('user_id', null)->get();
        $famousWorkoutImagesPaths = [];

        foreach ($famousWorkouts as $workout) {
            $famousWorkoutImagesPaths[$workout->workout_id] = ImageService::getImagePath('workouts/famous/plans', $workout->workout_id, config('images.workouts.default'));
        }

        $famousImages = File::files(public_path('images/workouts/famous/carousel'));

        return view('workouts.famousWorkouts', compact('famousImages', 'famousWorkouts', 'famousWorkoutImagesPaths'));
    }

    public function show($id)
    {
        $workoutDifficulty = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workoutGoals = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workoutTypes = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workoutGenders = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');
        $daysOfTheWeek = DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day');
        $dayImagePath = null;
        $exerciseImagePath = null;

        $workout = Workout::with('days.exerciseWorkout.exercise')->whereNull('user_id')->find($id);

        if ($workout === null) {
            return redirect()->route('famousWorkouts');
        }

        $imageService = new ImageService();
        $workoutPlanImg = $imageService->getImagePath('workouts/famous/plans', $workout->workout_id, config('images.workouts.default'));
        $workout->imagePath = $workoutPlanImg;

        foreach ($workout->days as $day) {
            $dayImagePath = $imageService->getImagePath('workouts/famous/days', $day->workout_day_id, config('images.days.default'));
            $day->daysImagePath = $dayImagePath;
            $dayImagePaths[] = $dayImagePath;

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



        return view('workouts.viewFamousWorkout', compact('workout', 'workoutPlanImg', 'days', 'dayImagePath', 'exerciseImagePath', 'daysOfTheWeek', 'workoutDifficulty', 'workoutGoals', 'workoutTypes', 'workoutGenders'));
    }

    public function store(Request $request, $id)
    {

        Request()->validate([
            'workout_id' => 'required|integer',
        ]);

        $user = Auth::user();

        if ($user->workout) {
            notify()->info('You already have a workout plan.');
            return redirect()->route('famousWorkouts');
        } else {
            $workout = Workout::with('days.exerciseWorkout.exercise')->whereNull('user_id')->find($id);

            if ($workout) {
                $newWorkout = $workout->replicate();
                $newWorkout->user_id = $user->id;
                $newWorkout->push();

                foreach ($workout->days as $day) {
                    $newDay = $day->replicate();
                    $newDay->workout_id = $newWorkout->workout_id;
                    $newDay->push();

                    foreach ($day->exerciseWorkout as $exerciseWorkout) {
                        $newExerciseWorkout = $exerciseWorkout->replicate();
                        $newExerciseWorkout->workout_day_id = $newDay->workout_day_id;
                        $newExerciseWorkout->push();
                    }
                }

                notify()->success('Workout plan copied successfully.');
                return redirect()->route('personalWorkoutPlan');
            } else {
                notify()->error('Workout plan not found.');
                return redirect()->route('famousWorkouts');
            }
        }
    }
}
