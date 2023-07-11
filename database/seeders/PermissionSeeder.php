<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $modules = ['role','user', 'itemcategory', 'subcategory' , 'brand', 'subbrand', 'customer','itemmaster','order'];
        $role_permissions = [
            '-view',
            '-create',
            '-update',
            '-delete',
            '-status',
        ];

        foreach ($modules as $module) {
            foreach ($role_permissions as $role_permission){
                Permission::create([
                    'module' => $module,
                    'name' => $module.$role_permission,
                    'guard_name' => 'admin',
                ]);
            }
        }
    
    }
}
