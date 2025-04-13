<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect([
            'data mental game' => [
                'create data mental game',
                'view data mental game',
                'edit data mental game',
                'delete data mental game',
            ],
            'data meditation' => [
                'create data meditation',
                'view data meditation',
                'edit data meditation',
                'delete data meditation',
            ],
            'data motivation' => [
                'create data motivation',
                'view data motivation',
                'edit data motivation',
                'delete data motivation',
            ],
            'data health cooking' => [
                'create data health cooking',
                'view data health cooking',
                'edit data health cooking',
                'delete data health cooking',
            ],
            'data fitness' => [
                'create data fitness',
                'view data fitness',
                'edit data fitness',
                'delete data fitness',
            ],
        ]);

        $permissions->map(function ($permission, $group) {
            collect($permission)->map(function ($name) use ($group) {
                $guard_name = 'web';

                Permission::query()
                    ->updateOrCreate(compact('name'), compact('name', 'group', 'guard_name'));
            });
        });
    }
}
