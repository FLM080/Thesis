<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\MuscleGroup;
use App\Models\Exercise;
use App\Services\DatabaseSchemaService;
use App\Services\ImageService;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $exerciseTypes = DatabaseSchemaService::getColumnEnums('exercise', 'exercise_type');
        $exerciseDifficulty = DatabaseSchemaService::getColumnEnums('exercise', 'exercise_strength_level');
        $exerciseGoal = DatabaseSchemaService::getColumnEnums('exercise', 'exercise_goal');
        $deleteRoute = 'deleteExercise';
        $tableId = 'exercise_id';
        $muscleGroups = MuscleGroup::all();
        $columns = DatabaseSchemaService::getColumnNames('exercise');
        $editRoute = 'editExercise';
        $searchRoute = 'adminExercise';
        $editType = 'exercise';

        $search = $request->get('search');
        $items = Exercise::with('muscleGroup')
        ->where('exercise_name', 'LIKE', "%{$search}%")
        ->orWhereHas('muscleGroup', function ($query) use ($search) {
            $query->where('muscle_group_name', 'LIKE', "%{$search}%");
        })
        ->orWhere('exercise_type', 'LIKE', "%{$search}%")
        ->orWhere('exercise_strength_level', 'LIKE', "%{$search}%")
        ->orWhere('exercise_goal', 'LIKE', "%{$search}%")
        ->get();

        if ($request->ajax()) {
            return view('partials._table', ['items' => $items, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute, 'editType' => $editType, 'muscleGroups' => $muscleGroups, 'exerciseTypes' => $exerciseTypes, 'exerciseDifficulty' => $exerciseDifficulty, 'exerciseGoal' => $exerciseGoal]);
        }
        return view('admin.exercise', compact('muscleGroups', 'exerciseTypes', 'exerciseDifficulty', 'exerciseGoal','items', 'columns', 'deleteRoute', 'tableId', 'editRoute', 'searchRoute', 'editType'));
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
            'exercise_name' => ['required', 'max:30', 'regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',Rule::unique('exercise', 'exercise_name')],
            'exercise_description' => ['required', 'max:150', 'regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i'],
            'exercise_type' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('exercise', 'exercise_type')),
            'exercise_strength_level' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('exercise', 'exercise_strength_level')),
            'exercise_goal' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('exercise', 'exercise_goal')),
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
            $image = ImageService::uploadAndResize($image, $exercise->exercise_id, '/images/exercises');
            $imageUploaded = true;
        }

        if ($imageUploaded) {
            $exerciseSaved = $exercise->save();
        }
        
        if ($imageUploaded && $exerciseSaved) {
            notify()->success(__('Successfully saved details'));
        } else {
            notify()->error(__('Failed to save details'));
        }
        return redirect(route('adminExercise'));
    }

    public function destroy(Request $request)
{
    $exercise = Exercise::find($request->id);
    $destinationPath = 'images/exercises';


    $imageDeleted = imageService::deleteImage($exercise->exercise_id, $destinationPath);

    if ($imageDeleted) {
        $exerciseDeleted = $exercise->delete();
    }
    
    if ($imageDeleted && $exerciseDeleted) {
        notify()->success(__('Exercise deleted successfully'));
    } else {
        notify()->error(__('Failed to delete exercise and image'));
    }
    return redirect(route('adminExercise'));
}

    public function update(Request $request, $id)
    {

        $exercise = Exercise::find($id);
        $extensions = config('images.profile.extension');
        $request->validate([
            'muscle_group_id' => 'required',
            'exercise_name' => ['required', 'max:30', 'regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i',Rule::unique('exercise', 'exercise_name')->ignore($exercise->exercise_id, 'exercise_id')],
            'exercise_description' => ['required', 'max:150', 'regex:/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s.,-]+$/i'],
            'exercise_type' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('exercise', 'exercise_type')),
            'exercise_strength_level' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('exercise', 'exercise_strength_level')),
            'exercise_goal' => 'required|in:' . implode(',', DatabaseSchemaService::getColumnEnums('exercise', 'exercise_goal')),
            'image' => 'image|mimes:' . implode(',', $extensions) . '',
        ]);

        $exercise->muscle_group_id = $request->muscle_group_id;
        $exercise->exercise_name = $request->exercise_name;
        $exercise->exercise_description = $request->exercise_description;
        $exercise->exercise_type = $request->exercise_type;
        $exercise->exercise_strength_level = $request->exercise_strength_level;
        $exercise->exercise_goal = $request->exercise_goal;
        $imageUploaded = false;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image = ImageService::uploadAndResize($image, $exercise->exercise_id, '/images/exercises');
            $imageUploaded = true;
        }

        $exerciseSaved = $exercise->save();

        if (!$imageUploaded && !$exerciseSaved) {

            notify()->error(__('Failed to update details'));
        } else if (!$imageUploaded) {

            notify()->warning(__('Successfully updated details, but failed to upload image'));
        } else if (!$exerciseSaved) {

            notify()->warning(__('Image uploaded successfully, but failed to update details'));
        } else {

            notify()->success(__('Successfully updated details'));
        }
        return redirect(route('adminExercise'));
    }
}
