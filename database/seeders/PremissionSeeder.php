<?php

namespace Database\Seeders;

use function PHPSTORM_META\map;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PremissionSeeder extends Seeder
{

    public $permissions = [
        // user permissions
        'create_user',
        'delete_user',
        'edit_user',
        'show_user',
        'edit_user_status',
        'change_user_role',
        // role permissions
        'create_role',
        'edit_role',
        'show_role',
        'delete_role',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        collect($this->permissions)->map(function ($per) {
            Permission::create(['name' => $per]);
        });
    }
}
