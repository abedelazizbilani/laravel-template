<?php

namespace App\Http\Controllers\Auth;

use App\Base\BaseController;
use App\Http\Requests\UserConfirmPasswordRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Jobs\SendEmail;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseController
{
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /*
     * request
     */
    protected $request;

    /**
     * @return array
     */
    protected $userRepository;

    /**
     * Create a new controller instance.
     * @param $request
     * @param $userRepository
     * @return void
     */
    public function __construct(Request $request, UserRepository $userRepository)
    {
        $this->request        = $request;
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Update a user.
     *
     * @param  \App\Http\Requests\UserResetPasswordRequest $request
     * @return mixed
     */
    public function resetPassword(UserResetPasswordRequest $request)
    {
        // reset user password
        $user = $this->userRepository->resetPassword($request);

        $data = [
            'template' => 'auth.passwords.reset-password',
            'subject' => env('MAIL_FROM_NAME') . ', Change Password Request',
            'to' => ['name' => $user->name, 'email' => $user->email],
            'username' => $user->username,
            'code' => $user->password_change_code,
            'link' => '/password/confirm',
        ];

        dispatch(new SendEmail($data));

        return redirect()->route('password.confirm');
    }

    public function confirmPassword(UserConfirmPasswordRequest $request)
    {
        if (!$this->userRepository->confirmPassword($request)){
            return 'reset_password_failed';
        }
        return redirect()->route('login');
    }


    public function showConfirmCodeForm()
    {
        return view('auth.passwords.confirm');
    }
}
