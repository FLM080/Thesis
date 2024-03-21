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
}
