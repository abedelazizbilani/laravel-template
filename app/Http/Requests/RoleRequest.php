<?php

namespace App\Http\Requests;

class RoleRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->role ? ',' . $this->role->id : '';
        return $rules = [
            'name' => 'bail|required|max:255|unique:roles,name,' . $id,
            'display_name' => 'bail|required|max:255|unique:roles,name,' . $id,
            'description' => 'bail|required|max:255|unique:roles,name,' . $id
        ];
    }
}
