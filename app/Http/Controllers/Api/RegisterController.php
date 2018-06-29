<?php

/**
 * RegisterController
 *
 * (c) Abed Bilani <abed.bilani@ideatolife.me>
 *
 */


namespace App\Http\Controllers\Api;

use App\Base\BaseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

        //five request per second only
        $this->middleware('throttle:5,1');
    }

    /**
     * Register new user
     */
    public function registerNewUser(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'password' => 'required|confirmed|min:6',
            'job_type' => 'required',
            'terms_conditions' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->failed('', response()->json($validator->errors())->original);
        }

        // if terms and conditions are accepted
        if (!request('terms_conditions')) {
            return $this->failed('you must accept terms and conditions');
        }

        //create new user record
        $user           = new User();
        $user->email    = request('email');
        $user->username = request('email');
        $user->name     = request('name');
        $user->password = Hash::make(request('password'));
        $user->phone    = request('phone');
        $user->job_type = request('job_type');
        $user->active   = 1;
        // attach role
        $role = Role::where('name', 'mobile')->first();
        $user->save();
        $user->attachRole($role);

        //send email and assign role

        //in case there is an issue
        if (!$user) {
            return $this->failed('couldnt created new user please try again later');
        }

        //set device and push token
        $user->linkDeviceIdAndPushToken();

        //Thank you for signing up on ! Check your inbox to verify your account'
        $toReturn          = $user->returnUser();
        $toReturn['token'] = $user->generateJWTToken();

        return $this->success('register success', $toReturn);
    }

}