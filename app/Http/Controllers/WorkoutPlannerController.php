<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseSchemaService;
use App\Models\Exercise;
use App\Models\Workout;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\WorkoutDay;
use App\Models\ExerciseWorkoutConnect;


class WorkoutPlannerController extends Controller
{
    public function index()
    {

        $workout = null;
        $personalImg = null;
        if (Auth::check()) {
            $user = Auth::user();
            $workout = $user->workout;

            if ($workout) {
                $imageService = new ImageService();
                $personalImg = $imageService->getImagePath('workouts/user/plans', $workout->workout_id, config('images.workouts.default'));
                $workout->imagePath = $personalImg;
            }
        }
        $columns = DatabaseSchemaService::getColumnNames('exercise');
        $items = Exercise::all();
        $images = File::files(public_path('images/workouts/famous/carousel'));
        $days = DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day');


        $workoutDifficulty = DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level');
        $workoutGoals = DatabaseSchemaService::getColumnEnums('workout', 'workout_goal');
        $workoutTypes = DatabaseSchemaService::getColumnEnums('workout', 'workout_type');
        $workoutGenders = DatabaseSchemaService::getColumnEnums('workout', 'workout_gender');

        $imageService = new ImageService();
        foreach ($items as $item) {
            $item->imagePath = $imageService->getImagePath('exercises', $item->exercise_id, config('images.exercises.default'));
        }

        $variablesToCompact = ['items', 'columns', 'workout', 'workoutDifficulty', 'workoutGoals', 'workoutTypes', 'workoutGenders', 'images', 'days', 'personalImg'];

        return view('workouts.workoutPlanner', compact($variablesToCompact));
    }

    public function store(Request $request)
    {

        $extensions = config('images.profile.extension');
        $request->validate([
            'workout_name' => ['required', 'max:40', 'regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i'],
            'workout_description' => 'required|max:254|regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',
            'workout_strength_level' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_strength_level')),
            'workout_goal' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_goal')),
            'workout_type' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout', 'workout_type')),
            'workout_gender' => 'required|in:Both,Male,Female',
            'workout_days' => 'required|integer|min:1|max:7',
            'workoutPlan_image' => 'nullable|image|mimes:' . implode(',', $extensions),
        ]);

        $workout = new Workout();
        $workout->user_id = Auth::id();
        $workout->workout_name = $request->workout_name;
        $workout->workout_description = $request->workout_description;
        $workout->workout_strength_level = $request->workout_strength_level;
        $workout->workout_goal = $request->workout_goal;
        $workout->workout_type = $request->workout_type;
        $workout->workout_gender = $request->workout_gender;
        $workout->workout_days = $request->workout_days;

        if ($workout->save()) {
            notify()->success(__('Successfully saved workout'));
        } else {
            notify()->error(__('Failed to save workout'));
        }

        if ($request->hasFile('workoutPlan_image')) {
            $image = $request->file('workoutPlan_image');
            $image = ImageService::uploadAndResize($image, $workout->workout_id, '/images/workouts/user/plans');
        }

        return redirect(route('workoutPlanner'));

    }

    public function addExercise(Request $request)
    {
        $movedCards = $request->input('movedCards');
        $imageService = new ImageService();


        $processedData = [];
    
        
        foreach ($movedCards as $card) {
            if (!isset($card['id'])) {
                continue;
            }
        
                $card['imageUrl'] = $imageService->getImagePath('exercises', $card['id'], config('images.exercises.default'));
                $processedData[] = $card;

        }
    
        return response()->json($processedData);
    }

    public function addWorkoutDay(Request $request)
    {

        $extensions = config('images.profile.extension');
        $request->validate([
            'workout_day_name' => 'required|max:30|regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',
            'workout_day_day' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('workout_day', 'workout_day')),
            'workout_image' => 'nullable|image|mimes:' . implode(',', $extensions),
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|integer|min:1',
            'exercises.*.order' => 'required|integer|min:1',
        ]);
    
        $workoutDay = WorkoutDay::firstOrNew(
            ['workout_id' => Auth::user()->workout->workout_id, 'workout_day_name' => $request->workout_day_name],
            ['workout_day' => $request->workout_day_day]
        );


        $numberOfDaysInWorkout = Auth::user()->workout->workout_days;
        $existingWorkoutDaysCount = WorkoutDay::where('workout_id', Auth::user()->workout->workout_id)->distinct('workout_day_name')->count('workout_day_name');

        if ($existingWorkoutDaysCount < $numberOfDaysInWorkout) {
            $workoutDay->save();
        
            foreach ($request->exercises as $exercise) {
                ExerciseWorkoutConnect::create([
                    'workout_day_id' => $workoutDay->workout_day_id,
                    'exercise_id' => $exercise['id'],
                    'exercise_workout_sets' => $exercise['sets'],
                    'exercise_workout_reps' => $exercise['reps'],
                    'exercise_workout_order' => $exercise['order'],
                ]);
            }

            if ($request->hasFile('workout_image')) {
                $image = $request->file('workout_image');
                $image = ImageService::uploadAndResize($image, $workoutDay->workout_day_id, '/images/workouts/user/days');
            }
        
            notify()->success(__('Successfully saved workout day'));
        } else {
            notify()->error(__('You have reached the maximum number of workout days for this workout plan'));
        }
        
        return redirect(route('workoutPlanner'));     
    }
}