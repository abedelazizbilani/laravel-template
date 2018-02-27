<?php
/**
 * Created by PhpStorm.
 * User: Abed Bilani
 * Date: 6/7/2017
 * Time: 12:56 PM
 */

namespace App\Models;


use App\Base\BaseModel;
use App\Base\BaseTranslationModel;
use App\Traits\TranslatableTrait;

class Country extends BaseModel
{

    use TranslatableTrait;
    public $translatedAttributes = ['name'];

    public function scopeById($query, $id)
    {
        return $query->where('id', $id);
    }
}

class CountryTranslation extends BaseTranslationModel
{
    public $timestamps = false;
    protected $fillable = ['name'];
}