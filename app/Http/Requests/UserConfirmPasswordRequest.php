<?php

namespace App\Http\Requests;

class UserConfirmPasswordRequest extends Request
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
            'confirmation_code' => 'exists:users,password_change_code',
        ];
    }
}
