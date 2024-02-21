<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function show()
    {
        $user = Auth::user(); 
        $preference = Preference::where('user_id', $user->id)->first(); 

            $columns = Preference::getSelectedColumns();
            $options = [];
            $selected = [];
    
            foreach ($columns as $column => $label) {
                $options[$column] =Preference::getEnumValues($column);
                $selected[$column] = $preference ? $preference->$column : null;}



    return view('users.profile' , compact('columns', 'options', 'selected'));
    }

    public function update(Request $request, $id)
    {
        $preference = Preference::find($id);

        $formFields = $request->validate([
            'goal' => ['required', 'in:lose_weight,get_fit,build_muscle'],
            'workout_type' => ['required', 'in:cardio,strength,flexibility'],
            'strength_level' => ['required', 'in:beginner,intermediate,advanced'],
        ]);

        $preference->update($formFields);

        notify()->success(__('Preference updated successfully'));
        return redirect('/profile');
    }


}
