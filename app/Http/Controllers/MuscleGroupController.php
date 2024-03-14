<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MuscleGroup;
use App\Services\DatabaseSchemaService;
use Illuminate\Validation\Rule;

class MuscleGroupController extends Controller
{
    public function index(Request $request)
    {
        $items = MuscleGroup::all();
        $columns = DatabaseSchemaService::getColumnNames('muscle_groups');
        $tableId = 'muscle_group_id';
        $deleteRoute = 'deleteMuscleGroup';
        $editRoute = 'editMuscleGroup';
        $searchRoute = 'adminMuscleGroup';
        $editType = 'muscleGroup';
        
        $search = $request->get('search');
        $items = MuscleGroup::where('muscle_group_name', 'like', "%{$search}%")->get();

        
        if ($request->ajax()) {
            return view('partials._table', ['items' => $items, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute, 'editType' => $editType]);
        }
        return view('admin.muscleGroup', compact('items', 'columns', 'tableId', 'deleteRoute', 'editRoute', 'searchRoute', 'editType'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'muscle_group_name' => ['required', 'max:30', 'regex:/^[a-zA-Z\s]+$/i', Rule::unique('muscle_groups', 'muscle_group_name')],
        ]);

        $muscleGroup = new MuscleGroup([
            'muscle_group_name' => $request->muscle_group_name,
        ]);

        if ($muscleGroup->save()) {
            notify()->success(__('Muscle Group added successfully'));
        } else {
            notify()->error(__('Failed to add Muscle Group'));
        }
        return redirect(route('adminMuscleGroup'));
    }

    public function show($id)
    {
        $muscleGroup = MuscleGroup::find($id);
        return response()->json($muscleGroup);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'muscle_group_name' => ['required', 'max:30', 'regex:/^[a-zA-Z\s]+$/i', \Illuminate\Validation\Rule::unique('muscle_groups', 'muscle_group_name')],
        ]);

        $muscleGroup = MuscleGroup::find($id);
        $muscleGroup->muscle_group_name = $validatedData['muscle_group_name'];

        if ($muscleGroup->isDirty()) {
            if ($muscleGroup->save()) {
                notify()->success(__('Muscle Group updated successfully'));
            } else {
                notify()->error(__('Failed to update Muscle Group'));
            }
        } else {
            notify()->info(__('No changes were made to the Muscle Group'));
        }

        return redirect(route('adminMuscleGroup'));
    }

    public function destroy($id)
    {
        $muscleGroup = MuscleGroup::find($id);
        $muscleGroup->delete();

        notify()->success(__('Muscle Group deleted successfully'));

        return redirect(route('adminMuscleGroup'));
    }
}
