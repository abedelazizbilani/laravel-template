<?php

/*
 * This is a middleware that ensure following things:
 * 1. First the incoming request has a content-type of JSON.
 * 2. Secondly the given json in the request has a valid json structure
 *
 */

namespace App\Http\Middleware;

use App\Traits\ExceptionTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class AppAuthenticate extends Authenticate
{
    use ExceptionTrait;

    public function authenticate(Request $request)
    {
        $this->checkForToken($request);

        try {
            $token     = $this->auth->parseToken();
            $tokenSign = $token->getPayload()->get('jwt_sign');
            $user      = $token->authenticate();
            if ( ! $user || ! $user->active) {
                $this->raiseAuthorizationException("user_not_exist_or_blocked");
            }
            if ($tokenSign != $user->jwt_sign) {
                $this->raiseAuthorizationException("user_credentials_update_please_login_again");
            }
        } catch (JWTException $e) {
            $this->raiseAuthorizationException("invalid_jwt_sign");
        }
    }
}