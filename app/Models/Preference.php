<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'preference';
    public $timestamps = false;

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

    public static function getUserPreferences($userId)
{
    return Preference::where('user_id', $userId)->first();
}


    
}