<?php

/*
 * This file is part of the IdeaToLife package.
 *
 * (c) Youssef Jradeh <youssef.jradeh@ideatolife.me>
 *
 */

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