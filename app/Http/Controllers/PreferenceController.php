<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    //update user preference
    public function update(Request $request)
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
        if ($preference->wasChanged()) {
            notify()->success(__('Successfully saved preference'));
        } else {
            notify()->error(__('Failed to save preference'));
        }
        return redirect('/profile');
    }
}
