<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-index',
            'role-store',
            'role-update',
            'role-destroy',
            'attendance-index',
            'attendance-store',
            'attendance-update',
            'attendance-destroy',
            'salary-index',
            'salary-store',
            'salary-update',
            'salary-destroy'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
