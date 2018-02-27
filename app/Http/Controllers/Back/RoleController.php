<?php

namespace App\Http\Controllers\Back;

use App\Base\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Traits\Indexable;

class RoleController extends BaseController
{
    use Indexable;

    /**
     * Create a new RoleController instance.
     *
     * @param  \App\Repositories\RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;

        $this->table = 'roles';
    }

    public static function validationRules()
    {
        return [];
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('back.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->repository->store($request);

        return redirect(route('roles.index'))->with('role-ok', __('The role has been successfully created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get();
        return view('back.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleUpdateRequest $request
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $this->repository->update($request, $role);

        return back()->with('role-updated', __('The role has been successfully updated'));
    }

    /**
     * Remove the role from storage.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->name = $role->name . str_random(5);
        $role->update();
        $role->delete();
        return response()->json();
    }
}
