<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

trait DisplayableValueTrait
{
    public function getDisplayValue($column)
    {
        $relationMethod = str_replace('_id', '', $column);

        if (method_exists($this, $relationMethod)) {
            $relation = $this->$relationMethod;
            $propertyName = $relationMethod . "_name";
            return $relation->$propertyName ?? $this->$column;
        } else {
            return $this->$column;
        }
    }
}

