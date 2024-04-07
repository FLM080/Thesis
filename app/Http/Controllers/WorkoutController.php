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
    public function index(Request $request)
    {
        $workout_strength_level = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workout_goal = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workout_type = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workout_gender = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');
        $days = DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day');
        $workout_plans = Workout::whereNull('user_id')->get();
        $exercises = Exercise::all();
        
        $columns = DatabaseSchemaService::getColumnNames('workout');
        $deleteRoute = 'deleteWorkoutPlanAdmin';
        $editRoute = 'showUpdateWorkoutPlanAdmin';
        $tableId = 'workout_id';
        $editType = 'workout';
        $searchRoute = 'adminWorkout';

        
        foreach ($exercises as $exercise) {
            $exercise->image_path = ImageService::getImagePath('exercises', $exercise->exercise_id, 'images/exercises/Default.jpg');
        }

        $search = $request->get('search');
        $items = Workout::whereNull('user_id')
        ->where('workout_name', 'LIKE', "%{$search}%")
        ->orWhere('workout_type', 'LIKE', "%{$search}%")
        ->orWhere('workout_strength_level', 'LIKE', "%{$search}%")
        ->orWhere('workout_goal', 'LIKE', "%{$search}%")
        ->orWhere('workout_days', 'LIKE', "%{$search}%")
        ->orWhere('workout_gender', 'LIKE', "%{$search}%")
        ->get();

        if ($request->ajax()) {
            return view('partials._table', ['items' => $items, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute, 'editType' => $editType]);
        }

        return view('admin.workout', compact('workout_strength_level', 'workout_goal', 'workout_type', 'workout_gender', 'days', 'workout_plans', 'exercises', 'items', 'columns', 'deleteRoute', 'editRoute', 'tableId', 'editType', 'searchRoute'));
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

        $workout = Workout::find($request->workout_plan);

        if (!$workout) {
            notify()->error('Workout plan not found');
            return redirect(route('adminWorkout'));
        }

        $dayCount = WorkoutDay::where('workout_id', $workout->workout_id)->count();

        if ($dayCount >= $workout->workout_days) {
            notify()->error('Workout plan has reached the maximum number of days');
            return redirect(route('adminWorkout'));
        }

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
            if (isset($imageUploaded) && $imageUploaded) {
                notify()->error('Image uploaded but workout day and exercises could not be saved');
            } else {
                notify()->error('Failed to save workout day and exercises');
            }
        }

        return redirect(route('adminWorkout'));
    }

    public function showUpdatePlan(Request $request)
    {

        $workoutDayImg = null;

        $workout = Workout::find($request->id);
        if ($workout) {
            $workoutPlanImg = ImageService::getImagePath('workouts/famous/plans/', $workout->workout_id, 'images/workouts/famous/plans/Default.jpg');
            $workout->imagePath = $workoutPlanImg;
        
            $days = $workout->days;
            foreach ($days as $day) {
                $day->workoutDayImg = ImageService::getImagePath('workouts/famous/days', $day->workout_day_id, 'images/workouts/famous/days/Default.jpg');                $exercises = [];
                foreach ($day->exerciseWorkout as $exerciseWorkoutConnect) {
                    $exercise = $exerciseWorkoutConnect->exercise;
                    $exercise->exerciseImg = ImageService::getImagePath('exercises', $exercise->exercise_id, 'images/exercises/Default.jpg');
                    $exercise->exercise_workout_order = $exerciseWorkoutConnect->exercise_workout_order;
                    $exercise->exercise_workout_sets = $exerciseWorkoutConnect->exercise_workout_sets;
                    $exercise->exercise_workout_reps = $exerciseWorkoutConnect->exercise_workout_reps;
                    $exercise->exercise_workout_id = $exerciseWorkoutConnect->exercise_workout_connect_id;
                    $exercises[] = $exercise;
                    $exercises = collect($exercises)->sortBy('exercise_workout_order')->values()->all();
                }
                $day->exercises = $exercises;
            }
        }
        
        $workoutTypes = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workoutDifficulty = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workoutGoals = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workoutGenders = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');
        $daysOfTheWeek = DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day');

        if (!$workout) {
            notify()->error('Workout plan not found');
            return redirect(route('adminWorkout'));
        }



        return view('admin.editFamousWorkout', compact('workout', 'workoutPlanImg', 'days', 'daysOfTheWeek', 'workoutDifficulty', 'workoutGoals', 'workoutTypes', 'workoutGenders', 'workoutDayImg'));
    }

    public function updateFamousWorkoutDay(Request $request)
    {
        $request->validate([
            'workout_day_name' => 'required|max:40|regex:/^[a-zA-Z\s.,-]+$/i',
            'workout_day' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day')),
            'WorkoutDayImage' => 'nullable|image|mimes:' . implode(',', config('images.profile.extension')),
        ]);

        $workoutDay = WorkoutDay::find($request->workout_day_id);
        $workoutDay->workout_day_name = $request->workout_day_name;
        $workoutDay->workout_day = $request->workout_day;

        $imageUploaded = false;
        if ($request->hasFile('WorkoutDayImage')) {
            $image = $request->file('WorkoutDayImage');
            $image = ImageService::uploadAndResize($image, $workoutDay->workout_day_id, '/images/workouts/famous/days');
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

        return redirect()->route('showUpdateWorkoutPlanAdmin', ['id' => $workoutDay->workout_id]);
    }

    public function destroyFamousWorkoutDay(Request $request)
    {
        $workoutDay = WorkoutDay::find($request->id);
        $destinationPath = 'images/workouts/famous/days';

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

        return redirect()->route('showUpdateWorkoutPlanAdmin', ['id' => $workoutDay->workout_id]);
    }

    public function updateFamousWorkoutDayExercise(Request $request)
    {
        $request->validate([
            'exercise_order' => 'required|integer|min:1',
            'exercise_sets' => 'required|integer|min:1',
            'exercise_reps' => 'required|integer|min:1',
        ]);
    
        $exerciseWorkout = ExerciseWorkoutConnect::find($request->id);
    
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
            
            $workoutDay = WorkoutDay::find($exerciseWorkout->workout_day_id);
            return redirect()->route('showUpdateWorkoutPlanAdmin', ['id' => $workoutDay->workout_id]);
        } else {
            notify()->error(__('Failed to find exercise'));
            return redirect()->route('adminWorkout');
        }
    }

    public function destroyFamousWorkoutDayExercise(Request $request)
    {
        $exerciseWorkoutConnect = ExerciseWorkoutConnect::find($request->id);
        $workoutDayId = $exerciseWorkoutConnect->workout_day_id->workout_id;
        if($exerciseWorkoutConnect::destroy($request->id)){
            notify()->success('Exercise deleted from workout day');
            return redirect()->route('showUpdateWorkoutPlanAdmin', ['id' => $workoutDayId]);
        } else {
            notify()->error('ExerciseWorkoutConnect not found');
            return redirect()->route('showUpdateWorkoutPlanAdmin', ['id' => $workoutDayId]);
        }
    }

    public function updateFamousWorkoutPlan(Request $request)
    {
        $imageUploaded = false;
        $extensions = config('images.profile.extension');
        $request->validate([
            'workout_name' => 'required', 'max:40', 'regex:/^[a-zA-Z\s.,-]+$/i',
            'workout_description' => 'required|max:254|regex:/^[a-zA-Z\s.,-]+$/i',
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
            $image = ImageService::uploadAndResize($image, $workout->workout_id, '/images/workouts/famous/plans');
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

        return redirect()->route('showUpdateWorkoutPlanAdmin', ['id' => $workout->workout_id]);
    }
}
