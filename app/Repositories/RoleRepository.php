<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;

class RoleRepository
{
    /**
     * Get roles collection paginate.
     *
     * @param  int $nbrPages
     * @param  array $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($parameters)
    {
        return Role::orderBy($parameters['order'], $parameters['direction'])
            ->get();
    }

    /**
     * Update a role.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @param  \App\Models\Role $role
     * @return void
     */
    public function update($request, $role)
    {
        $inputs          = $request->all();
        $rolePermissions = $role->perms()->get();
        $role->detachPermissions($rolePermissions);
        $role->update($inputs);
        // check if has permissions
        if (!empty($inputs['permissions'])) {
            foreach ($inputs['permissions'] as $permissionId => $value) {
                if ($value == 1) {
                    $permission = Permission::find($permissionId);
                    $role->attachPermission($permission);
                }
            }
        }

    }

    /**
     * Store post.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @return void
     */
    public function store($request)
    {
        $inputs             = $request->all();
        $role               = new Role();
        $role->name         = $inputs['name'];
        $role->display_name = $inputs['display_name']; // optional
        $role->description  = $inputs['description']; // optional
        $role->save();
        // check if has permissions
        if (!empty($inputs['permissions'])) {
            foreach ($inputs['permissions'] as $permissionId => $value) {
                if ($value == 1) {
                    $permission = Permission::find($permissionId);
                    $role->attachPermission($permission);
                }
            }
        }
    }
}
