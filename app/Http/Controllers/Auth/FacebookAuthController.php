<?php

namespace App\Http\Controllers\Auth;

use App\Base\BaseController;
use App\Services\FacebookUserService;
use Laravel\Socialite\Facades\Socialite as SocialLogin;

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
    public function callback(FacebookUserService $service)
    {
        $user = $service->createOrGetUser(SocialLogin::driver('facebook')->user());
        auth()->login($user);
        return redirect()->to('/dashboard');
    }
}
