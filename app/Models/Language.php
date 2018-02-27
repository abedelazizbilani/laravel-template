<?php

namespace App\Models;

use App\Base\BaseModel;

class Language extends BaseModel
{
    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }
}