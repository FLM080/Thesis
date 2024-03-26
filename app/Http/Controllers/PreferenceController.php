<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'preference_goal' => 'required|in:lose weight,build muscle,maintain weight',
            'preference_workout_type' => 'required|in:bodyweight,weight training,with cardio,no equipment',
            'preference_strength_level' => 'required|in:beginner,intermediate,advanced',
        ]);
        $user = Auth::user();
        $preference = Preference::where('user_id', $user->id)->first();

        if (!$preference) {
            $preference = new Preference();
            $preference->user_id = $user->id;
            $preference->save();
        }
        $preference->preference_goal = $request->preference_goal;
        $preference->preference_workout_type = $request->preference_workout_type;
        $preference->preference_strength_level = $request->preference_strength_level;

        
        if ($preference->isDirty()) {
            if ($preference->save()) {
                notify()->success(__('Successfully saved preference'));
            } else {
                notify()->error(__('Failed to save preference'));
            }
        } else {
            notify()->info(__('No changes to save'));
        }
            return redirect(route('profile'));
        }
}
