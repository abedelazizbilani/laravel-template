<?php

/**
 * ResetPasswordController
 *
 * (c) Abed Bilani <abed.bilani@ideatolife.me>
 *
 */


namespace App\Http\Controllers\Api;


use App\Base\BaseController;
use App\Jobs\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResetPasswordController extends BaseController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

        //five request per second only
        $this->middleware('throttle:5,1');
    }

    public function resetPassword(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->failed('', response()->json($validator->errors(), 422)->original);
        }

        //check if email exist
        $user = User::where("email", $request->email)->first();

        if (!$user || !$user->email) {
            return $this->failed("it seems that this email does not exist in our database");
        }

        //search email and check
        $user->password_change_code   = str_random(5);
        $user->password_change_expiry = Carbon::now()->addMinutes(60);
        $user->save();

        $data = [
            'template' => 'auth.passwords.reset-password',
            'subject' => env('MAIL_FROM_NAME') . ', Change Password Request',
            'to' => ['name' => $user->name, 'email' => $user->email],
            'username' => $user->username,
            'code' => $user->password_change_code,
        ];

        dispatch(new SendEmail($data));

        return $this->success("reset password code sent");
    }

    public function confirmPassword(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
            'password' => 'required|confirmed|min:6',
            'password_change_code' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->failed('', response()->json($validator->errors(), 422)->original);
        }

        $user = User::where("email", $request->email)->first();

        if (!$user || !$user->email) {
            return $this->failed("invalid username");
        }

        $current = Carbon::now();
        $expiry  = Carbon::parse($user->password_change_expiry);

        //checking the code sent and if it is not expired
        if ($current->diffInSeconds($expiry, false) < 1
            || $user->password_change_code !== $request->password_change_code
        ) {
            return $this->failed("password reset code is invalid or expired");
        }

        //update user request
        $user->password_change_code   = null;
        $user->password_change_expiry = null;
        $user->password_changed_at    = $current;
        $user->password               = \Hash::make(request('password'));
        $user->save();

        return $this->success();
    }
}