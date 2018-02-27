<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates    = ['deleted_at'];

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'user_id', 'role_id');
    }
}
