<?php

namespace App\Http\Controllers\Auth;

use App\Base\BaseController;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;

class LoginController extends BaseController
{

    use AuthenticationTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'log';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $logValue = $request->input($this->username());

        $logKey = filter_var($logValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [
            $logKey => $logValue,
            'password' => $request->input('password'),
        ];
    }
}
