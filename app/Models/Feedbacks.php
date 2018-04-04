<?php
/**
 * Created by PhpStorm.
 * Date: 5/16/2017
 * Time: 2:59 PM
 */

namespace App\Models;


use App\Base\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedbacks extends BaseModel
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByUserId($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeByTarget($query, $id)
    {
        return $query->where('id', $id);
    }
}