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

    public function getUserPreference($user)
    {
        $preferences = Preference::where('user_id', $user->id)->first();

        $columns = Preference::getSelectedColumns();
        $options = [];
        $selected = [];

        

        foreach ($columns as $column => $label) {
            $options[$column] = Preference::getEnumValues($column);
            $selected[$column] = $preferences ? $preferences->$column : null;
        }
        
        return compact('columns', 'options', 'selected');
    }
}
