<?php

/**
 * RoleUser
 *
 * (c) Abed Bilani <abed.bilani@gmail.com>
 *
 */


namespace App\Models;


use App\Base\BaseModel;

class RoleUser extends BaseModel
{
    public $timestamps = false;
    protected $table = 'role_user';

    public function users()
    {
        return $this->hasMany(User::class , 'id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'id');
    }

    public function scopeByUserId($query , $id)
    {
        return $query->where('user_id',$id);
    }
}