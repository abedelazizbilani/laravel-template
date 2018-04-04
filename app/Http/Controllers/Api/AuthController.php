<?php

/**
 * AuthController
 *
 * (c) Abed Bilani <abed.bilani@gmail.com>
 *
 */


namespace App\Http\Controllers\Api;


use App\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends BaseController
{

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    /**
     * @param \Tymon\JWTAuth\JWTAuth $jwt
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(JWTAuth $jwt, Request $request)
    {
        parent::__construct($request);

        //five request per second only
        $this->middleware('throttle:5,1');

        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $email = request('email');
        $password = request('password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = $this->jwt->attempt(['email' => $email, 'password' => $password])) {
                return $this->failed('idea::general.invalid_user_name_or_password');
            }

            $this->user = Auth::user();

            //check if user deactivated
            if (!$this->user->active) {
                return $this->failed('idea::general.your_account_is_still_deactivated');
            }

            //set device and push token
            $this->user->linkDeviceIdAndPushToken();

            $toReturn          = $this->user->returnUser();
            $toReturn['token'] = $this->user->generateJWTToken();

            return $this->success('idea::general.login_success', $toReturn);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->failed('idea::general.could_not_authenticate_user');
        }
    }
}