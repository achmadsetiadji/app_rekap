<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetRoleRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     *
     * @var UserRepository
     */
    protected $user;

    /**
     *
     * @var RoleRepository
     */
    protected $role;

    public function __construct(
        UserRepository $user,
        RoleRepository $role
    ) {
        $this->user = $user;
        $this->role = $role;

        app()['cache']->forget('spatie.permission.cache');
    }

    /**
     * Menampilkan view superadmin/users/index
     *
     * @return mixed
     */
    public function index()
    {
        $roles = $this->role->all()->pluck('name', 'name');
        $usersByRoles = $this->role->getUsersByRole();

        $countAllUsersByRoles = $this->user->all()->count();

        return view('superadmin.users.index', compact(
            'roles',
            'usersByRoles',
            'countAllUsersByRoles'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function data(Request $request)
    {
        $data = $this->user->all($request->all());

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('name', function ($data) {
                $avatarUrl = $data->avatar ? load_file($data->avatar) : asset('assets/img/avatar-placeholder.png');
                return "
                    <div class='d-flex align-items-center'>
                        <img src='$avatarUrl' width='50' height='50'>
                        <div class='d-inline-block ml-3'>
                            <span class='d-block mb-3 text-dark font-weight-bold'>$data->name</span>
                            <a class='text-muted' href='mailto:$data->email' target='_blank'>$data->email</a>
                        </div>
                    </div>
                ";
            })
            ->addColumn('role', function ($data) {
                $roles = explode(',', $data->role);

                if (empty($roles)) {
                    return "";
                }

                $text = '';
                foreach ($roles as $role) {
                    $text .= "
                    <span class='badge badge-primary mr-2 bg-"
                        .  $data->getRoleColor($role) . "'>" . ucwords($role) .
                        "</span>";
                }

                return $text;
            })
            ->addColumn('action', function ($data) {
                $button = "";

                $button .= "
                    <button class='btn btn-warning text-white'
                        onclick='editForm(`" . route(auth()->user()->role .
                            '.user.show', $data->id) . "`, `Edit User`)'>
                        <i class='fa-solid fa-pen'></i>
                        Edit
                    </button>
                    &nbsp
                    <button class='btn btn-danger'
                        onclick='deleteData(`" . route(auth()->user()->role .
                            '.user.destroy', $data->id) . "`)'>
                        <i class='fa-solid fa-trash'></i>
                        Delete
                    </button>
                ";

                return $button;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $attributes = $request->all();

            $emailParts = explode('@', $request->email);
            $emailName = $emailParts[0];

            if ($request->hasFile('avatar')) {
                $avatar = uploadFile('avatar', $request->avatar, 'avatar-' . $emailName);
                $attributes['avatar'] = $avatar;
            }

            if ($request->has('password')) {
                $attributes['password'] = bcrypt($request->password);
            } else {
                $attributes['password'] = bcrypt('000000');
            }

            $user = $this->user->create($attributes);
            $user->syncRoles($request->role);

            DB::commit();
            return $this->ok($user, 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->user->find($id);
        $user->role = explode(',', $user->role);

        if (!$user) {
            return $this->oops('User tidak ditemukan');
        }

        return $this->ok($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return $this->oops('User tidak ditemukan');
        }

        DB::beginTransaction();
        try {
            $attributes = $request->all();

            if ($request->has('password') && $request->password != "") {
                $attributes['password'] = bcrypt($request->password);
            } else {
                $attributes['password'] = bcrypt('000000');
            }

            // Check if a new image file is uploaded
            if ($request->hasFile('avatar')) {
                $emailParts = explode('@', $request->email);
                $emailName = $emailParts[0];

                deleteFile($user->avatar);

                $avatar = uploadFile('avatar', $request->avatar, 'avatar-' . $emailName);
                $attributes['avatar'] = $avatar;
            }

            $user = $this->user->update($attributes, $id);
            $user->syncRoles($request->role);

            DB::commit();
            return $this->ok($user, 'User berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->find($id);
            if (!$user) {
                return $this->oops('User tidak ditemukan.');
            }

            deleteFile($user->avatar);
            $this->user->delete($user->id);

            DB::commit();
            return $this->ok(null, 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }

    /**
     * Set a role to user selected
     *
     * @param SetRoleRequest $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function setRole(SetRoleRequest $request, $userId)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->find($userId);
            $user->syncRoles($request->role);

            $attributes = [
                'role' => $request->role
            ];

            $this->user->update($attributes, $user->id);

            $response = [
                'id'        => $user->id,
                'email'     => $user->email,
                'role'      => $user->roles->pluck('name')[0] ?? ''
            ];

            DB::commit();
            return $this->ok($response, 'Role berhasil di SET');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }
}
