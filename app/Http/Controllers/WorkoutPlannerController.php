<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutPlannerController extends Controller
{
    public function show()
    {
        return view('workouts.workoutPlanner');
    }

}