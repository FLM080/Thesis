<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MuscleGroup;
use App\Models\Exercise;
use App\Services\DatabaseSchemaService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Provider\Time\FixedTimeProvider;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $exerciseTypes = DatabaseSchemaService::getColumnEnums('exercise', 'exercise_type');
        $exerciseDifficulty = DatabaseSchemaService::getColumnEnums('exercise', 'exercise_strength_level');
        $exerciseGoal = DatabaseSchemaService::getColumnEnums('exercise', 'exercise_goal');
        $deleteRoute = 'deleteExercise';
        $tableId = 'exercise_id';
        $exercises = Exercise::all();
        $muscleGroups = MuscleGroup::all();
        $items = Exercise::all();
        $columns = DatabaseSchemaService::getColumnNames('exercise');
        $editRoute = 'editExercise';
        $searchRoute = 'searchExercise';

        $search = $request->get('search');
        $exercises = Exercise::where('exercise_name', 'like', "%{$search}%")
            ->orWhere('muscle_group_id', 'like', "%{$search}%")
            ->orWhere('exercise_type', 'like', "%{$search}%")
            ->orWhere('exercise_strength_level', 'like', "%{$search}%")
            ->orWhere('exercise_goal', 'like', "%{$search}%")
            ->get();

        if ($request->ajax()) {
            return view('partials._table', ['items' => $exercises, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute]);
        }
        return view('admin.exercise', compact('muscleGroups', 'exerciseTypes', 'exerciseDifficulty', 'exerciseGoal', 'exercises','items', 'columns', 'deleteRoute', 'tableId', 'editRoute', 'searchRoute'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $exercises = Exercise::where('name', 'like', '%' . $search . '%')->get();
        return view('partials.exercises_table', ['items' => $exercises]);
    }

    public function store(Request $request)
    {
        $extensions = config('images.profile.extension');
        $request->validate([
            'muscle_group_id' => 'required',
            'exercise_name' => 'required|max:20',
            'exercise_description' => 'required|max:50',
            'exercise_type' => 'required|in:bodyweight,weight training,with cardio,no equipment',
            'exercise_strength_level' => 'required|in:beginner,intermediate,advanced',
            'exercise_goal' => 'required|in:lose weight,build muscle,maintain weight',
            'image' => 'required|image|mimes:' . implode(',', $extensions) . '',
        ]);
    
        $exercise = new Exercise([
            'muscle_group_id' => $request->muscle_group_id,
            'exercise_name' => $request->exercise_name,
            'exercise_description' => $request->exercise_description,
            'exercise_type' => $request->exercise_type,
            'exercise_strength_level' => $request->exercise_strength_level,
            'exercise_goal' => $request->exercise_goal
        ]);
    
        $exercise->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = strtolower($image->getClientOriginalExtension());
            Log::info('Extension: ' . $extension);
            $name = $exercise->exercise_id . '.' . $extension;
            Log::info('Name: ' . $name);
            $destinationPath = 'images/exercises';
        
            $image->storeAs($destinationPath, $name);
        
            $existingFiles = glob(public_path($destinationPath) . '/' . $exercise->id . '.*');
            foreach ($existingFiles as $existingFile) {
                if (is_file($existingFile) && $existingFile !== public_path($destinationPath) . '/' . $name) {
                    unlink($existingFile);
                }
            }
        
            $resizedImage = Image::make($image)->resize(320, 320, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        
            $resizedImage->save(public_path($destinationPath . '/' . $name));
            $imageUploaded = true;
        }
        
        if ($imageUploaded) {
            notify()->success(__('Successfully saved details'));
        } else {
            notify()->error(__('Failed to save details'));
        }
        return redirect('/exercise');
    }

    public function destroy(Request $request)
    {
        $exercise = Exercise::find($request->id);
        $exercise->delete();
        return redirect('/exercise');
    }
}
