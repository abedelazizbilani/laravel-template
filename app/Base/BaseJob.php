<?php

/*
 * This file is part of the IdeaToLife package.
 *
 * (c) Youssef Jradeh <youssef.jradeh@ideatolife.me>
 *
 */

namespace App\Base;

use App\Jobs\Job;

/**
 * Eloquent Model Base class
 */
Abstract class BaseJob extends Job
{
    public $params = [];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array $attributes
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }
}