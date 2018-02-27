<?php

namespace App\Models;

use App\Base\BaseModel;
use App\Jobs\SendEmail;
use App\Traits\Authenticatable;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Zizaco\Entrust\Contracts\EntrustUserInterface;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends BaseModel implements JWTSubject, AuthenticatableContract, EntrustUserInterface
{
    use Authenticatable;
    use SoftDeletes, EntrustUserTrait {

        SoftDeletes::restore as sfRestore;
        EntrustUserTrait::restore as euRestore;

    }


    protected     $dates     = ['deleted_at'];
    public static $jwtCmsKey = "nhq";
    protected     $fillable  = ['email', 'name', 'active', 'username', 'password'];
    protected     $hidden    = [
        'password',
        'jwt_sign',
        'email_confirm_code',
        'email_confirm_expiry',
        'email_confirmed_at',
        'password_change_code',
        'password_change_expiry',
        'password_changed_at',
    ];


    /**
     * Create a new Eloquent model instance.
     *
     * @param  array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /*
     * this function is set user relation with Profile
     * a user can have many one profile
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /*
     * this function is set user relation with Devices
     * a user can have many devices
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedbacks::class);
    }

    /*
     * this function is set user relation with roles
     * a user can have many roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    /*
     * this function is set user relation with Notifications
     * a user can have many Notifications
     */
    public function notifications()
    {
        return $this->hasMany(UserNotifications::class, 'user_id');
    }

    /*
     * this function is set user relation with Devices
     * a user have on only one latest device
     */
    public function latestDevice()
    {
        return $this->hasOne(Device::class)->latest();
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {

        //create jwt sign on the fly
        if (!$this->jwt_sign) {
            $this->updateJWTSign();
        }

        $claims = ["jwt_sign" => $this->jwt_sign];
        if ($this->isCmsUser()) {
            $claims[self::$jwtCmsKey] = 1;
        }

        return $claims;
    }

    public function restore() {
        $this->sfRestore();
        Cache::tags(Config::get('entrust.role_user_table'))->flush();
    }

    /*
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeByKey($query, $key)
    {
        return $query->where('name', 'LIKE', '%' . $key . '%')->orWhere('username', 'LIKE', '%' . $key . '%');
    }

    /*
     * Functions
     */
    public function updateJWTSign()
    {
        $this->jwt_sign = Str::random();
        $this->save();
    }

    /*
     * this function is to activate user account
     * */
    public function activate()
    {
        $this->active = 1;

        return $this->save();
    }

    public function linkDevice()
    {
        $device          = app("DeviceInfo");
        $device->user_id = $this->id;

        return $device->save();
    }

    public function linkToken($deviceToken)
    {
        $device        = app("DeviceInfo");
        $device->token = $deviceToken;

        return $device->save();
    }

    public function isCmsUser()
    {
        $roles       = $this->roles()->get();
        $hasExternal = false;
        foreach ($roles as $role) {
            if ($role->slug == 'external') {
                $hasExternal = true;
            }
        }

        if ($hasExternal && count($roles) == 1) {
            return false;
        }

        return true;
    }

    /*
     * this function is to assign External role to a user
     * */
    public function assignExternalRole()
    {
        $role = Role::where("slug", "external")->first();
        $this->roles()->attach($role->id);
    }

    /*
     * this function is to assign a role and a permission to a user
     * */
    public function assignRolePermission($roleId)
    {
        //delete existing user
        UserRole::byUserId($this->id)->delete();

        foreach ($roleId as $id) {
            $role = Role::where("id", $id)->first();
            if ($role) {
                $this->roles()->attach($role->id);
            } else
                break;
        }
    }


    //TODO DEFINE WHAT TO RETURN
    public function getMoreInfo()
    {
        return [];
    }


    /*
     * this function is to link device Id with the user id
     * using a Token
     * */
    public function linkDeviceIdAndPushToken()
    {
        //link the current device
        $this->linkDevice();

        //update device token
        if (request('user_device_token')) {
            $this->linkToken(request('user_device_token'));
        }
    }

    /**
     * this function is to return user's info
     *
     * @param      $user
     * @param bool $withToken
     *
     * @return array
     * @internal param $token
     */
    public function returnUser()
    {
        //return user info
        $toReturn = [
            'user' => [
                "id" => $this->id,
                "username" => $this->username,
                "user_full_name" => $this->name,
                "user_profile_picture" => $this->image,
            ],
            'info' => $this->getMoreInfo(),
        ];

        return $toReturn;
    }

    /*
     * generate Token
     * */
    public function generateJWTToken($ttl = 0)
    {
        if ($ttl) {
            JWTAuth::factory()->setTTL($ttl);
        }

        return JWTAuth::fromUser($this);
    }

    /*
     * this function is to create an instance of a new user from
     * \App\Models\User if exists else create user instance from
     * \Idea\Models\User
     * */
    protected function getUserClassInstance()
    {
        if (class_exists('\App\Models\User')) {
            return new \App\Models\User();
        }

        return new User();
    }


    public function notifyUser()
    {
        if (config('auth.verify_emails') && $this->email) {
            $this->sendActivateEmail();
        } else {
            $this->activate();
            $this->sendWelcomeEmail();
        }
    }

    private function sendActivateEmail()
    {
        $this->email_confirm_code   = str_random(5);
        $this->email_confirm_expiry = Carbon::now()->addMinutes(60);
        $this->save();

        $data = array(
            'template' => 'emails.verify',
            'subject' => env('MAIL_FROM_NAME') . ', Verify your email',
            'to' => ['name' => $this->name, 'email' => $this->email],
            'username' => $this->username,
            'code' => $this->email_confirm_code,
        );

        dispatch(new SendEmail($data));

        return true;
    }

    private function sendWelcomeEmail()
    {
        if (!$this->email) {
            return true;
        }
        $data = array(
            'template' => 'emails.welcome',
            'subject' => 'Welcome to ' . env('MAIL_FROM_NAME') . '!',
            'to' => ['name' => $this->name, 'email' => $this->email],
            'username' => $this->username,
        );

        // dispatch(new SendEmail($data));

        return true;
    }

    public function notifyOwner()
    {
        //get the facebook user id
        $facebookToken = UserProviderToken::byUser($this->id)->facebook()->first();

        //fill the data array
        $data = array(
            'template' => 'emails.notify-owner',
            'sendToOwner' => true,
            'subject' => env('MAIL_FROM_NAME') . ', New User!',
            'user_id' => $this->id,
            'user_full_name' => $this->name,
            'user_email' => $this->email,
            'user_facebook_user_id' => isset($facebookToken->id) ? $facebookToken->token_id : "",
            'total_users_count' => User::count(),
        );
        dispatch(new SendEmail($data));
    }

}
