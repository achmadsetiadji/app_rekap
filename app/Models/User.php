<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are guarded
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    /**
     * Mengambil warna berdasarkan role
     *
     * @param string $role
     * @return string
     */
    public function getRoleColor($role)
    {
        $color = '';

        // TODO : sesuaikan role color dengan role yang dipakai di aplikasi
        switch ($role) {
            case 'admin':
                $color = 'green';
                break;

            case 'user':
                $color = 'red';
                break;
        }

        return $color;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->hasRole(['admin']);
    }

    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        // TODO : isi has role di dalam dengan role yang boleh di impersonate
        return $this->hasRole(['user']);
    }
}
