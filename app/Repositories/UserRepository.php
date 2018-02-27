<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Get users collection paginate.
     *
     * @param  int $nbrPages
     * @param  array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($nbrPages, $parameters)
    {
        return User::orderBy($parameters['order'], $parameters['direction'])
            ->when(
                $parameters['valid'], function ($query) {
                $query->whereValid(true);
            })->paginate($nbrPages);
    }

    /**
     * Update a user.
     *
     * @param  \App\Http\Requests\UserUpdateRequest $request
     * @param  \App\Models\User $user
     * @return void
     */
    public function update($request, $user)
    {
        $inputs = $request->all();

        if (isset($inputs['confirmed'])) {
            $inputs['confirmed'] = true;
        }

        if (isset($inputs['valid'])) {
            $inputs['valid'] = true;
        }
        // remove all roles for this user
        $user->detachRoles();

        // check if roles are set
        if (!empty($inputs['roles'])) {
            foreach ($inputs['roles'] as $roleId) {
                //attach roles
                $role = Role::find($roleId);
                $user->attachRole($role);
            }
        }
        $user->update($inputs);
    }

    /**
     * Store post.
     *
     * @param  \App\Http\Requests\UerRequest $request
     * @return void
     */
    public function store($request)
    {
        $inputs = $request->all();

        $inputs['password'] = bcrypt($inputs['password']);

        $user = User::create($inputs);

        // check if roles are set
        if (!empty($inputs['roles'])) {
            foreach ($inputs['roles'] as $roleId) {
                //attach roles
                $role = Role::find($roleId);
                $user->attachRole($role);
            }
        }

        $profileInputs['user_id'] = $user->id;
        Profile::create($profileInputs);
    }

    public function resetPassword($request)
    {
        // get user by email
        $user = User::where("email", $request->email)->first();

        // disable user and set reset code
        $user->active = 0;
        $user->password_change_code = str_random(5);
        $user->password_change_expiry = Carbon::now()->addMinutes(60);

        if (!$user->save()) {
            return null;
        }
        // return user to send email
        return $user;
    }

    public function confirmPassword($request)
    {
        // get user by email
        $user = User::where("email", $request->email)->first();

        $current = Carbon::now();
        $expiry = Carbon::parse($user->password_change_expiry);

        //checking the code sent and if it is not expired
        if ($current->diffInSeconds($expiry, false) < 1
            || $user->password_change_code !== $request->confirmation_code
        ) {
            return false;
        }

        //update user request
        $user->password_change_code = null;
        $user->password_change_expiry = null;
        $user->password_changed_at = $current;
        $user->password = Hash::make($request->password);
        //save user data
        if (!$user->save()) {
            return false;
        }
        // return password has changed
        return true;
    }

}
