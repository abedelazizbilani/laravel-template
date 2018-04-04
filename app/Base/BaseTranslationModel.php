<?php



namespace App\Base;


/**
 * Eloquent Model Base class
 */
Abstract class BaseTranslationModel extends BaseModel
{
    public $timestamps = false;
    public $hideTimestamp = false;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];
}