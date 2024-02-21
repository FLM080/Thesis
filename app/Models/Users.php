<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Users extends Model
{
    use HasFactory;
    protected  $table = 'users';
    public $timestamps = false;


        
    public static function getColumnEnums($columnName)
    {
        $query = "SHOW COLUMNS FROM users WHERE Field = '$columnName'";
        $result = DB::select($query)[0]->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $result, $matches);
        $enums = explode("','", $matches[1]);
        return $enums;
    }

    


    public static function getGenderColumn()
    {
        $query = 'SHOW COLUMNS FROM users WHERE Field = "gender"';
        $result = DB::select($query)[0]->Field;
        return $result;
    }
}