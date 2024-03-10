<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuscleGroup extends BaseModel
{
    use HasFactory;

    protected $table = 'muscle_groups';
    protected $primaryKey = 'muscle_group_id';
    public $timestamps = false;

    protected $fillable = [
        'muscle_group_name',
    ];


    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'muscle_group_id', 'muscle_group_id');
    }
}
