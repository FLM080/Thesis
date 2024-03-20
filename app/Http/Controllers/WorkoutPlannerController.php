<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\DatabaseSchemaService;
use App\Models\Exercise;
use App\Services\ImageService;

class WorkoutPlannerController extends Controller
{
    public function index()
    {

        $columns = DatabaseSchemaService::getColumnNames('exercise');
        $items = Exercise::all();
        $extensions = config('images.profile.extension');

        $imageService = new ImageService();
        foreach ($items as $item) {
            $item->imagePath = $imageService->getImagePath('exercises', $item->exercise_id, config('images.exercises.default'));
        }

        return view('workouts.workoutPlanner', compact('items', 'columns'));
    }

}