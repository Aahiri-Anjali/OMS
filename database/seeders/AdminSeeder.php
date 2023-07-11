<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
       $admin =  Admin::create(['name'=>'Admin',
                        'email'=>'admin@admin.com',
                        'password'=>Hash::make('admin@123'),
                    ]);


        $role = Role::create(['name' => 'Admin','guard_name'=>'admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->givePermissionTo($permissions);
        $admin->assignRole($role);
    }
}
