<?php

namespace App\Models;

use App\Base\BaseModel;

class Device extends BaseModel
{
    public function scopeByType($query, $type = null)
    {
        if (is_array($type)){
            return $query->whereIn('type', $type);
        }
        return $query;
    }
}
