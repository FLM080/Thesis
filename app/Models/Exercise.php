<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;



class Exercise extends BaseModel
{
    use HasFactory;
    protected $table = 'exercise';
    protected $primaryKey = 'exercise_id';
    public $timestamps = false;

    protected $fillable = [
        'muscle_group_id',
        'exercise_name',
        'exercise_description',
        'exercise_type',
        'exercise_strength_level',
        'exercise_goal',
    ];

    public function muscle_group()
    {
        return $this->belongsTo(MuscleGroup::class, 'muscle_group_id');
    }


}
