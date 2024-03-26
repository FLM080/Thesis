<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutDay extends Model
{
    use HasFactory;
    protected $table = 'workout_day';
    protected $primaryKey = 'workout_day_id';
    public $timestamps = false;

    protected $fillable = ['workout_id', 'workout_day_name', 'workout_day'];

    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    public function exerciseWorkout()
    {
        return $this->hasMany(ExerciseWorkoutConnect::class, 'workout_day_id');
    }
}
