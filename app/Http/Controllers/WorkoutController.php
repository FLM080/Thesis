<?php

namespace App\Http\Controllers;

use App\Services\DatabaseSchemaService;
use Illuminate\Http\Request;
use App\Models\Workout;
use App\Services\ImageService;
use App\Models\Exercise;
use App\Models\WorkoutDay;
use App\Models\ExerciseWorkoutConnect;
use Illuminate\Support\Facades\Log;

class WorkoutController extends Controller
{
    public function index()
    {
        $workout_strength_level = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workout_goal = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workout_type = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workout_gender = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');
        $days = DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day');
        $workout_plans = Workout::whereNull('user_id')->get();
        $exercises = Exercise::all();
        
        foreach ($exercises as $exercise) {
            $exercise->image_path = ImageService::getImagePath('exercises', $exercise->exercise_id, 'images/exercises/Default.jpg');
        }

        return view('admin.workout', compact('workout_strength_level', 'workout_goal', 'workout_type', 'workout_gender', 'days', 'workout_plans', 'exercises'));
    }

    public function storePlan(Request $request)
    {
        $extensions = config('images.profile.extension');
        $request->validate([
            'workout_name' => 'required|max:30|regex:/^[a-zA-Z\s.,-]+$/i',
            'workout_description' => 'required|max:150|regex:/^[a-zA-Z\s.,-]+$/i',
            'workout_strength_level' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level')),
            'workout_goal' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_goal')),
            'workout_type' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_type')),
            'workout_gender' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_gender')),
            'workout_days' => 'required|min:1|max:7|integer',
            'workoutPlan_image' => 'required|image|mimes:' . implode(',', $extensions) . '',
        ]);

        $workout = new Workout();
        $workout->workout_name = $request->workout_name;
        $workout->workout_description = $request->workout_description;
        $workout->workout_strength_level = $request->workout_strength_level;
        $workout->workout_goal = $request->workout_goal;
        $workout->workout_type = $request->workout_type;
        $workout->workout_gender = $request->workout_gender;
        $workout->workout_days = $request->workout_days;
        $workout->user_id = null;

        $workout->save();

        if ($request->hasFile('workoutPlan_image')) {
            $image = $request->file('workoutPlan_image');
            $image = ImageService::uploadAndResize($image, $workout->workout_id, 'images/workouts/famous/plans');
            $imageUploaded = true;
        }

        if ($workout->save()) {
            if ($imageUploaded) {
                notify()->success('Workout plan and image created successfully');
            } else {
                notify()->error('Workout plan created but image could not be uploaded');
            }
        } elseif ($imageUploaded) {
            notify()->error('Image uploaded but workout plan could not be saved');
        } else {
            notify()->error('Failed to save workout plan and image');
        }
        
        return redirect(route('adminWorkout'));
    }

    public function destroyPlan(Request $request)
    {
        $workout = Workout::find($request->id);
        $destinationPath = 'images/workouts/famous/plans';

        $imageDeleted = ImageService::deleteImage($workout->workout_id, $destinationPath);

        if ($imageDeleted) {
            $workout->delete();
            notify()->success('Workout plan deleted successfully');
        } else {
            notify()->error('Failed to delete workout plan and image');
        }

        return redirect(route('adminWorkout'));
    }

    public function storeDay(Request $request)
    {

        $extensions = config('images.profile.extension');
        $request->validate([
            'workout_plan' => 'required|integer',
            'workout_day_name' => 'required|max:30|regex:/^[a-zA-Z\s.,-]+$/i',
            'workout_day_day' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day')),
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|integer',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|integer|min:1',
            'exercises.*.order' => 'required|integer|min:1',
            'workout_day_image' => 'nullable|image|mimes:' . implode(',', $extensions) . '',
        ]);

        try {
            $workoutDay = new WorkoutDay([
                'workout_id' => $request->workout_plan,
                'workout_day' => $request->workout_day_day,
                'workout_day_name' => $request->workout_day_name,
            ]);
        
            $workoutDay->save();

            foreach ($request->exercises as $exercise) {
                $exerciseWorkoutConnect = new ExerciseWorkoutConnect([
                    'workout_day_id' => $workoutDay->id,
                    'exercise_id' => $exercise['exercise_id'],
                    'exercise_workout_sets' => $exercise['sets'],
                    'exercise_workout_reps' => $exercise['reps'],
                    'exercise_workout_order' => $exercise['order'],
                ]);
                $workoutDay->exerciseWorkout()->save($exerciseWorkoutConnect);
            }

            $exerciseWorkoutConnect->save();
        
            $imageUploaded = false;
            
            if ($request->hasFile('workout_day_image')) {
                $image = $request->file('workout_day_image');
                $image = ImageService::uploadAndResize($image, $workoutDay->workout_day_id, 'images/workouts/famous/days');
                $imageUploaded = true;
            }
        
            $workoutDay->save();
        
            if ($imageUploaded) {
                notify()->success('Workout day and image created successfully');
            } else {
                notify()->info('Workout day created but image was not uploaded');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage()); // Log the exception message
            if (isset($imageUploaded) && $imageUploaded) {
                notify()->error('Image uploaded but workout day and exercises could not be saved');
            } else {
                notify()->error('Failed to save workout day and exercises');
            }
        }

        return redirect(route('adminWorkout'));
    }
}
