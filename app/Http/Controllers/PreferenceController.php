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
            $options[$column] = Preference::getEnumValues($column);
            $selected[$column] = $preference ? $preference->$column : null;
        }
        
        return compact('columns', 'options', 'selected');
    }

    //update user preference
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $preference = Preference::where('user_id', $user->id)->first();
        if (!$preference) {
            $preference = new Preference();
            $preference->user_id = $user->id;
        }
        $preference->goal = $request->goal;
        $preference->workout_type = $request->workout_type;
        $preference->strength_level = $request->strength_level;
        $preference->save();
        return redirect('/profile');
    }
}
