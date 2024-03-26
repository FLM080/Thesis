<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class DatabaseSchemaService
{
    public static function getColumnEnums($tableName, $columnName)
    {
        $columns = DB::select("SHOW COLUMNS FROM {$tableName} WHERE Field = ?", [$columnName]);
    
        if (empty($columns)) {
            throw new Exception("No column named {$columnName} found in table {$tableName}");
        }
    
        $type = $columns[0]->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
    
        if (empty($matches)) {
            throw new Exception("The column {$columnName} is not of type ENUM");
        }
    
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