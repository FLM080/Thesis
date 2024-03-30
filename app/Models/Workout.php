<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;
    protected $table = 'workout';
    protected $primaryKey = 'workout_id';
    public $timestamps = false;
    

    public function days()
    {
        return $this->hasMany('App\Models\WorkoutDay', 'workout_id', 'workout_id');
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
