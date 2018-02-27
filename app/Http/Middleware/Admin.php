<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ExceptionTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class Admin extends Authenticate
{
    use ExceptionTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //TODO Ask magid if we still need this function
        $user = $request->user();

        if ($user && @admin) {
            return $next($request);
        }

        return redirect()->route('home');
    }

    public function authenticate(Request $request)
    {
        $this->checkForToken($request);

        try {
            $token     = $this->auth->parseToken();
            $tokenSign = $token->getPayload()->get('jwt_sign');
            $isCmsUser   = $token->getPayload()->get(User::$jwtCmsKey);
            if ( ! $isCmsUser) {
                $this->raiseAuthorizationException("invalid_admin_jwt");
            }

            $user = $token->authenticate();

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
