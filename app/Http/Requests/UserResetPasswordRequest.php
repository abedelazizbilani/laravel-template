<?php

namespace App\Http\Requests;

class UserResetPasswordRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'email' => 'exists:users,email',
        ];
    }
}
