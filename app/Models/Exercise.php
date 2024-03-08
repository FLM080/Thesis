<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Exercise extends Model
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
        'exercise_goal'
    ];
    
    public static function getSelectedColumns()
    {
        return [
            'muscle_group_id' => 'Muscle Group',
            'exercise_name' => 'Exercise Name',
            'exercise_description' => 'Description',
            'exercise_type' => 'Exercise Type',
            'exercise_strength_level' => 'Exercise Strength Level',
            'exercise_goal' => 'Exercise Goal'
        ];
    }

    public function muscleGroup()
    {
        return $this->belongsTo(MuscleGroup::class, 'muscle_group_id', 'muscle_group_id');
    }

    public static function getColumnEnums($tableName, $columnName)
    {
        $type = DB::select("SHOW COLUMNS FROM {$tableName} WHERE Field = ?", [$columnName])[0]->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enums = explode("','", $matches[1]);
        return $enums;
    }
}
