<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{


    /**
     * Update a role.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest $request
     * @param  \App\Models\Profile $profile
     * @return void
     */
    public function update($request, $profile)
    {
        $inputs = $request->all();

        $profile->update($inputs);
    }
}
