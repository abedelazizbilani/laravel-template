<?php

namespace App\Http\Controllers\Auth;

use App\Base\BaseController;
use SocialLogin;

class FacebookAuthController extends BaseController
{
    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect()
    {
        return SocialLogin::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback()
    {

    }
}
