<?php

/*
 * This file is part of the IdeaToLife package.
 *
 * (c) Youssef Jradeh <youssef.jradeh@ideatolife.me>
 *
 */

namespace App\Base;

use App\Helpers\StringHelper;
use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BaseSeeder extends seeder
{
    /**
     * Function to create seeds for permissions table
     * @param $permission
     */
    public function PermissionSeed($permission){
        $seed = [
            'name' => $permission,
            'display_name' => ucwords(str_replace("_", " ", $permission)),
            'description' => ucwords(str_replace("_", " ", $permission)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return $seed;
    }
}