<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetRolePermissionRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RolePermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $role;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var PermissionRepository
     */
    protected $permission;

    /**
     * @var RolePermissionRepository
     */
    protected $rolePermission;

    public function __construct(
        RoleRepository $role,
        UserRepository $user,
        PermissionRepository $permission,
        RolePermissionRepository $rolePermission
    ) {
        $this->role = $role;
        $this->user = $user;
        $this->permission = $permission;
        $this->rolePermission = $rolePermission;
    }

    /**
     * show the index of page
     *
     * @param   Request  $request
     *
     * @return  mixed
     */
    public function index(Request $request)
    {
        $usersByRoles = $this->role->getUsersByRole();
        $countAllUsersByRoles = $this->user->all()->count();
        $permissions = $this->permission->all();
        $roleName = $request->has('name') && $request->name != "" ? $request->name : 'superadmin';

        if (!empty($roleName)) {
            $roleSelected  = $this->role->findByName($roleName);
            $hasPermissions = $this->rolePermission->roleHasPermissions($roleSelected)->toArray();
        }

        return view('superadmin.roles.index', compact(
            'usersByRoles',
            'countAllUsersByRoles',
            'permissions',
            'roleName',
            'roleSelected',
            'hasPermissions'
        ));
    }

    /**
     * Set permissions to role selected
     *
     * @param SetRolePermissionRequest $request
     * @param string $role
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setRolePermissions(SetRolePermissionRequest $request, $role)
    {
        DB::beginTransaction();
        try {
            $role = $this->role->setRolePermissions($role, $request->permissions);

            $response = [
                'role' => $role->name,
                'permissions' => $role->permissions->pluck('name')
            ];

            DB::commit();
            return $this->ok($response, "Permission untuk role {$role->name} berhasil di SET");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }
}
