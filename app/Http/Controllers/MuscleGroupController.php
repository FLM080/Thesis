<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MuscleGroup;

class MuscleGroupController extends Controller
{
    public function index()
    {
        $muscleGroups = MuscleGroup::all();
        return view('admin.muscleGroup', compact('muscleGroups'));
    }

    public function store(Request $request)
    {
        $muscleGroupName = $request->input('muscle_group_name');

        if (empty($muscleGroupName)) {
            notify()->error(__('Muscle Group name cannot be empty'));
            return redirect('/muscleGroup');
        }

        $muscleGroups = MuscleGroup::all();
        foreach ($muscleGroups as $muscleGroup) {
            if ($muscleGroup->muscle_group_name == $muscleGroupName) {
                notify()->error(__('Muscle Group name already exists'));
                return redirect('/muscleGroup');
            }
        }

        if (strlen($muscleGroupName) > 30) {
            notify()->error(__('Muscle Group name cannot be longer than 30 characters'));
            return redirect('/muscleGroup');
        }

        if (!ctype_alnum($muscleGroupName)) {
            notify()->error(__('Muscle Group name cannot contain special characters'));
            return redirect('/muscleGroup');
        }

        $muscleGroup = new MuscleGroup();
        $muscleGroup->muscle_group_name = $muscleGroupName;

        if ($muscleGroup->save()) {
            notify()->success(__('Muscle Group added successfully'));
            return redirect('/muscleGroup');
        } else {
            notify()->error(__('Failed to add Muscle Group'));
            return redirect('/muscleGroup');
        }
    }

    public function show($id)
    {
        $muscleGroup = MuscleGroup::find($id);
        return response()->json($muscleGroup);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'muscle_group_name' => 'required|max:30|alpha_num',
        ]);

        $muscleGroup = MuscleGroup::find($id);
        $muscleGroup->muscle_group_name = $validatedData['muscle_group_name'];
        $muscleGroup->save();

        notify()->success(__('Muscle Group updated successfully'));

        return redirect('/muscleGroup');
    }

    public function destroy($id)
    {
        $muscleGroup = MuscleGroup::find($id);
        $muscleGroup->delete();

        notify()->success(__('Muscle Group deleted successfully'));

        return redirect('/muscleGroup');
    }
}
