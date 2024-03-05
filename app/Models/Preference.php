<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\DatabaseSchemaService;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'preference';
    protected $primaryKey = 'preference_id';
    public $timestamps = false;

    public static function getSelectedColumns()
    {
        return [
            'preference_goal' => 'Goal',
            'preference_workout_type' => 'Workout Type',
            'preference_strength_level' => 'Strength Level',
        ];
    }


    public function getUserPreference($user)
    {
        $table = 'preference';
        $preferences = Preference::where('user_id', $user->id)->first();

        $columns = Preference::getSelectedColumns();
        $options = [];
        $selected = [];

        

        foreach ($columns as $column => $label) {
            $options[$column] = DatabaseSchemaService::getColumnEnums($table, $column);
            $selected[$column] = $preferences ? $preferences->$column : null;
        }
        
        return compact('columns', 'options', 'selected');
    }
}
