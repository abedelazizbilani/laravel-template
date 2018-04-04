<?php
/**
 * Created by PhpStorm.
 * Date: 6/7/2017
 * Time: 12:49 PM
 */

namespace App\Models;

use App\Base\BaseModel;
use Intervention\Image\Facades\Image;
use App\Services\Thumb;

class Profile extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'middle_name', 'last_name', 'phone', 'gender', 'dob', 'country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    /*
     * this function is to set profile relation with user
     * a profile can be owned by one user only
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function scopeByUser($query, $id)
    {
        return $query->where('user_id', $id);
    }

    /*
      * this function is to add a profile image to a user check if
      * image is valid ,we don't need to raise any exception here,
      * so if the image is not valid or we couldn't resize it, then
      * return false
      *
      * @param $user
      */
    public function saveUserProfileImage($file)
    {

        try {
            //create new name
            $folderPath = 'uploads/' . $this->id . '/profile_picture/';
            $folder = public_path($folderPath);
            $name = str_replace(' ', '_', rand(5000, 100000) . "_" . $file->getClientOriginalName());

            //create folder if not exist
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                chmod($folder, 0777);
            }
            //save the image after resize it
            Image::make($file->getRealPath())->fit(250, 250)->save($folder . $name);
            $this->image = $folderPath . $name;
            $this->save();

            Thumb::makeThumb($this);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}