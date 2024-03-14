<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\MuscleGroup;
use App\Models\Exercise;
use App\Services\DatabaseSchemaService;
use Intervention\Image\ImageManagerStatic as Image;

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
        $searchRoute = 'adminExercise';
        $editType = 'exercise';

        $search = $request->get('search');
        $exercises = Exercise::where('exercise_name', 'like', "%{$search}%")
            ->orWhere('muscle_group_id', 'like', "%{$search}%")
            ->orWhere('exercise_type', 'like', "%{$search}%")
            ->orWhere('exercise_strength_level', 'like', "%{$search}%")
            ->orWhere('exercise_goal', 'like', "%{$search}%")
            ->get();

        if ($request->ajax()) {
            return view('partials._table', ['items' => $exercises, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute, 'editType' => $editType, 'muscleGroups' => $muscleGroups, 'exerciseTypes' => $exerciseTypes, 'exerciseDifficulty' => $exerciseDifficulty, 'exerciseGoal' => $exerciseGoal]);
        }
        return view('admin.exercise', compact('muscleGroups', 'exerciseTypes', 'exerciseDifficulty', 'exerciseGoal', 'exercises','items', 'columns', 'deleteRoute', 'tableId', 'editRoute', 'searchRoute', 'editType'));
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
            'exercise_name' => ['required', 'max:30', 'regex:/^[a-zA-Z\s]+$/i',Rule::unique('exercise', 'exercise_name')],
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
            $name = $exercise->exercise_id . '.' . $extension;
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

        if ($imageUploaded && $exercise->save()) {
            notify()->success(__('Successfully saved details'));
        } else {
            notify()->error(__('Failed to save details'));
        }
        return redirect(route('adminExercise'));
    }

    public function destroy(Request $request)
    {
        $extensions = config('images.profile.extension');
        $exercise = Exercise::find($request->id);
        $destinationPath = 'images/exercises';
        $imageDeleted = false;

        foreach ($extensions as $extension) {
            $fileToDelete = public_path($destinationPath) . '/' . $exercise->exercise_id . '.' . $extension;

            if (is_file($fileToDelete)) {
                if (unlink($fileToDelete)) {
                    $imageDeleted = true;
                    break;
                }
            }
        }

        if ($imageDeleted) {
            $exercise->delete();
            notify()->success(__('Exercise deleted successfully'));
        } else {
            notify()->error(__('Failed to delete exercise'));
        }
        return redirect(route('adminExercise'));
    }

    public function update(Request $request, $id)
    {

        $exercise = Exercise::find($id);
        $extensions = config('images.profile.extension');
        $request->validate([
            'muscle_group_id' => 'required',
            'exercise_name' => ['required', 'max:30', 'regex:/^[a-zA-Z\s]+$/i',Rule::unique('exercise', 'exercise_name')->ignore($exercise->exercise_id, 'exercise_id')],
            'exercise_description' => 'required|max:50',
            'exercise_type' => 'required|in:bodyweight,weight training,with cardio,no equipment',
            'exercise_strength_level' => 'required|in:beginner,intermediate,advanced',
            'exercise_goal' => 'required|in:lose weight,build muscle,maintain weight',
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
            $extension = strtolower($image->getClientOriginalExtension());
            $name = $exercise->exercise_id . '.' . $extension;
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

        if ($exercise->isDirty()) {
            if ($imageUploaded){
                if ($exercise->save()) {
                        notify()->success(__('Successfully updated details'));     
                }
            } else {
                notify()->error(__('Failed to update details'));
            }
        } else {
            notify()->info(__('No changes to save'));
        }
        return redirect(route('adminExercise'));
    }
}
