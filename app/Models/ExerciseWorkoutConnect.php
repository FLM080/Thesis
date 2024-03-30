<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseWorkoutConnect extends Model
{
    use HasFactory;
    protected $table = 'exercise_workout_connect';
    protected $primaryKey = 'exercise_workout_connect_id';
    public $timestamps = false;

    protected $fillable = [
        'workout_day_id',
        'exercise_id',
        'exercise_workout_sets',
        'exercise_workout_reps',
        'order',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
