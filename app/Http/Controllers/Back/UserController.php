<?php

namespace App\Http\Controllers\Back;

use App\Base\BaseController;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\Indexable;

class UserController extends BaseController
{
    use Indexable;

    /**
     * Create a new UserController instance.
     *
     * @param  \App\Repositories\UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'users';
    }

    public static function validationRules()
    {
        return [];
    }

    /**
     * Update "valid" field for user.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function updateValid(User $user)
    {
        $user->valid = true;
        $user->save();

        return response()->json();
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('display_name', 'id')->all();
        return view('back.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->repository->store($request);

        return redirect(route('users.index'))->with('user-ok', __('The user has been successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $userRoles    = [];
        $roles = Role::pluck('display_name', 'id')->all();
        $userRolesObj = $user->roles()->get();
        foreach ($userRolesObj as $userRole) {
            $userRoles[] = $userRole->id;
        }
        return view('back.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserUpdateRequest $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
            $this->repository->update($request, $user);
            return back()->with('user-updated', __('The user has been successfully updated'));
    }

    /**
     * Remove the user from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->username = $user->username . str_random(5);
        $user->email    = $user->email . str_random(5);
        $user->name    = $user->name . str_random(5);
        $user->update();
        $user->delete();
        return response()->json();
    }
}
