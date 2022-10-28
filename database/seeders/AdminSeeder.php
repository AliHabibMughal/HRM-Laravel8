<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\{Role, Permission};

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Ali Habib',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin1234'),
            'DOB' => '1999/12/17',
            'address' => 'DHA 4',
            'phone' => '03114545455',
            'designation' => 'Web Dev',
        ]);

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'HR'])
        ->syncPermissions([
            'attendance-index',
            'attendance-store',
            'attendance-update',
            'attendance-destroy',
            'salary-index',
            'salary-store',
            'salary-update',
            'salary-destroy'
        ]);

        $role = Role::create(['name' => 'Employee'])
        ->syncPermissions([
            'attendance-index',
            'attendance-store',
            'attendance-update',
            'salary-index',
        ]);

    }
}
