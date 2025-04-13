<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Superadmin\{
    RoleController,
    UserController,
};

Route::group([
    'prefix' => 'superadmin',
    'middleware' => 'role:superadmin',
    'as' => 'superadmin.'
], function () {
    Route::get('/', function () {
        return redirect()->route('rekap_laporan.index');
    });

    // User
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('user', UserController::class)->except('create', 'edit');
    Route::post('/user/role/{userId}', [UserController::class, 'setRole'])->name('user.set_role');

    // Role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role/permission/{role}', [RoleController::class, 'setRolePermissions'])->name('role.set_permissions');
});
