<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatabaseSchemaService
{
    public static function getColumnEnums($tableName, $columnName)
    {

    
        $type = DB::select("SHOW COLUMNS FROM {$tableName} WHERE Field = ?", [$columnName])[0]->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enums = explode("','", $matches[1]);
        return $enums;
    }

    public static function getColumnNames($tableName)
    {
        $columns = DB::select("SHOW COLUMNS FROM {$tableName}");
        $columnNames = [];
        foreach ($columns as $column) {
            $columnNames[] = $column->Field;
        }
        return $columnNames;
    }


}