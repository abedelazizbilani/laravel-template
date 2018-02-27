<?php

namespace App\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers as AuthenticatesUsersBase;
use Illuminate\Http\Request;

trait AuthenticationTrait
{
    use AuthenticatesUsersBase;

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (!$this->checkCredential($request)) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        // If user is confirmed we make the login and delete session information if needed
        $this->attemptLogin($request);
        if ($request->session()->has('user_id')) {
            $request->session()->forget('user_id');
        }
        return $this->sendLoginResponse($request);
    }

    /**
     * Check credential.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    protected function checkCredential($request)
    {
        return $this->guard()->validate($this->credentials($request));
    }
}
