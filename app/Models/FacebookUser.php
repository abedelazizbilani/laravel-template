<?php

namespace App\Models;

use App\Base\BaseModel;

class FacebookUser extends BaseModel
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
