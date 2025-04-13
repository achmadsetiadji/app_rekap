<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     *
     * @var UserRepository
     */
    protected $user;

    public function __construct(
        UserRepository $user,
    ) {
        $this->user = $user;
    }

    public function showFormProfil()
    {
        return view('superadmin.users.profil');
    }

    /**
     * Update profil user
     *
     * @param UpdateProfilRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfil(UpdateProfilRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            $attributes['name'] = $request->nama;
            $attributes['email'] = $request->email;

            $user->update($attributes);

            DB::commit();
            return $this->ok($user, 'Profile successfully updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }

    /**
     * Update password user
     *
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            $attributes['password'] = Hash::make($request->password);

            $user->update($attributes);

            DB::commit();

            return $this->ok($user, 'Password successfully updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->oops($e->getMessage());
        }
    }
}
