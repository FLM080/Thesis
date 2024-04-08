<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use App\Models\Workout;
use App\Services\DatabaseSchemaService;
use App\Models\WorkoutDay;
use App\Models\ExerciseWorkoutConnect;
use Illuminate\Support\Facades\Log;

class WorkoutPlanController extends Controller
{
    public function index()
    {
        $workoutDifficulty = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workoutGoals = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workoutTypes = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workoutGenders = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');
        $daysOfTheWeek = DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day');

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
                $workoutPlanImg = $imageService->getImagePath('workouts/user/plans', $workout->workout_id, config('images.workouts.default'));
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

        return view('users.viewWorkout', compact('workout', 'workoutPlanImg', 'days', 'dayImagePath', 'exerciseImagePath', 'daysOfTheWeek', 'workoutDifficulty', 'workoutGoals', 'workoutTypes', 'workoutGenders'));
    }

    public function updateWorkoutPlan(Request $request)
    {
        $imageUploaded = false;
        $extensions = config('images.profile.extension');
        $request->validate([
            'workout_name' => 'required', 'max:40', 'regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',
            'workout_description' => 'required|max:254|regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',
            'workout_strength_level' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level')),
            'workout_goal' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_goal')),
            'workout_type' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_type')),
            'workout_gender' => 'required|in:Both,Male,Female',
            'workout_days' => 'required|integer|min:1|max:7',
            'workoutPlan_image' => 'nullable|image|mimes:' . implode(',', $extensions),
        ]);

        $workout = Workout::find($request->workout_id);
        $workout->workout_name = $request->workout_name;
        $workout->workout_description = $request->workout_description;
        $workout->workout_strength_level = $request->workout_strength_level;
        $workout->workout_goal = $request->workout_goal;
        $workout->workout_type = $request->workout_type;
        $workout->workout_gender = $request->workout_gender;
        $workout->workout_days = $request->workout_days;

        if ($request->hasFile('workoutPlan_image')) {
            $image = $request->file('workoutPlan_image');
            $image = ImageService::uploadAndResize($image, $workout->workout_id, '/images/workouts/user/plans');
            if ($image) {
                $imageUploaded = true;
            }
        }
        
        if ($workout->isDirty() || $imageUploaded) {
            if ($workout->save()) {
                notify()->success(__('Successfully updated workout'));
            } else {
                notify()->error(__('Failed to update workout'));
            }
        } else {
            notify()->info(__('No changes were made to the workout'));
        }

        return redirect()->route('personalWorkoutPlan');

    }

    public function destroyWorkoutPlan($id)
{
    $workout = Workout::find($id);
    $destinationPath = 'images/workouts/user/plans';

    if ($workout) {

        $imageDeleted = ImageService::deleteImage($workout->workout_id, $destinationPath);

        if ($imageDeleted) {
            $workout->delete();
            notify()->success(__('Workout plan deleted successfully'));
        } else {
            notify()->error(__('Failed to delete workout image'));
        }
    } else {
        notify()->error(__('Failed to find workout plan'));
    }

    return redirect()->route('personalWorkoutPlan');
}

    public function updateWorkoutDay(Request $request)
    {
        $request->validate([
            'workout_day_name' => 'required|max:40|regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',
            'workout_day' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day')),
            'WorkoutDayImage' => 'nullable|image|mimes:' . implode(',', config('images.profile.extension')),
        ]);

        $workoutDay = WorkoutDay::find($request->workout_day_id);
        $workoutDay->workout_day_name = $request->workout_day_name;
        $workoutDay->workout_day = $request->workout_day;

        $imageUploaded = false;
        if ($request->hasFile('WorkoutDayImage')) {
            $image = $request->file('WorkoutDayImage');
            $image = ImageService::uploadAndResize($image, $workoutDay->workout_day_id, '/images/workouts/user/days');
            if ($image) {
                $imageUploaded = true;
            }
        }

        if ($workoutDay->isDirty() || $imageUploaded) {
            if ($workoutDay->save()) {
                notify()->success(__('Successfully updated workout day'));
            } else {
                notify()->error(__('Failed to update workout day'));
            }
        } else {
            notify()->info(__('No changes were made to the workout day'));
        }

        return redirect()->route('personalWorkoutPlan');
    }

    public function destroyWorkoutDay($id)
    {
        $workoutDay = WorkoutDay::find($id);
        $destinationPath = 'images/user/days'; 

        if ($workoutDay) {
            $imageDeleted = ImageService::deleteImage($workoutDay->workout_day_id, $destinationPath);

            if ($imageDeleted) {
                $workoutDay->delete();
                notify()->success(__('Workout day deleted successfully'));
            } else {
                notify()->error(__('Failed to delete workout day image'));
            }
        } else {
            notify()->error(__('Failed to find workout day'));
        }

        return redirect()->route('personalWorkoutPlan');
    }

    public function updateWorkoutDayExercise(Request $request)
    {
        $request->validate([
            'exercise_order' => 'required|integer|min:1',
            'exercise_sets' => 'required|integer|min:1',
            'exercise_reps' => 'required|integer|min:1',
        ]);



        $exerciseWorkout = ExerciseWorkoutConnect::find($request->exercise_workout_id);
        if ($exerciseWorkout) {
            $exerciseWorkout->exercise_workout_reps = $request->exercise_reps;
            $exerciseWorkout->exercise_workout_sets = $request->exercise_sets;
            $exerciseWorkout->exercise_workout_order = $request->exercise_order;
    
            if ($exerciseWorkout->isDirty()) {
                if ($exerciseWorkout->save()) {
                    notify()->success(__('Successfully updated exercise'));
                } else {
                    notify()->error(__('Failed to update exercise'));
                }
            }
        } else {
            notify()->error(__('Failed to find exercise'));
        }
    
        return redirect()->route('personalWorkoutPlan');
        
    }

    public function destroyWorkoutDayExercise($id)
    {
        $exerciseWorkout = ExerciseWorkoutConnect::find($id);



        if ($exerciseWorkout) {
            $exerciseWorkout->delete();
            notify()->success(__('Exercise deleted successfully'));
        } else {
            notify()->error(__('Failed to delete exercise'));
        }

        return redirect()->route('personalWorkoutPlan');
    }
}
