<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds for spatie role and permissions
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = array(
            ["id" => 1, "name" => "admin"]
        );

        foreach ($roles as $role){
            if(!Role::where("name",$role["name"])->first()) {
                Role::create(['name' => $role["name"]]);
            }
        }

        $permissions = array (
            ["id" => 1, "name" => "delete profile"]
        );

        foreach ($permissions as $permission){
            if(!Permission::where("name",$permission["name"])->first()) {
                Permission::create(['name' => $permission["name"]]);
            }
        }
    }
}
