<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'preference';
    protected $fillable = ['goal', 'workout_type', 'strength_level'];

    public static function getSelectedColumns()
    {
        return [
            'goal' => 'Goal',
            'workout_type' => 'Workout Type',
            'strength_level' => 'Strength Level',
        ];
    }

    public static function getEnumValues($column)
    {
        $query = "SHOW COLUMNS FROM preference WHERE Field = '{$column}'";
        $type = DB::select($query)[0]->Type;
        $enumValues = [];
        preg_match_all("/'([^']+)'/", $type, $matches);
        $enumValues = $matches[1];
        return $enumValues;
    }
    
}