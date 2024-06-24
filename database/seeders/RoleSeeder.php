<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        Permission::create(['name' => 'show_user']);
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'edit_user']);
        Permission::create(['name' => 'delete_user']);

        Permission::create(['name' => 'show_role']);
        Permission::create(['name' => 'create_role']);
        Permission::create(['name' => 'edit_role']);
        Permission::create(['name' => 'delete_role']);

        Permission::create(['name' => 'show_category']);
        Permission::create(['name' => 'create_category']);
        Permission::create(['name' => 'edit_category']);
        Permission::create(['name' => 'delete_category']);

        Permission::create(['name' => 'show_product']);
        Permission::create(['name' => 'create_product']);
        Permission::create(['name' => 'edit_product']);
        Permission::create(['name' => 'delete_product']);

        Permission::create(['name' => 'show_customer']);
        Permission::create(['name' => 'create_customer']);
        Permission::create(['name' => 'edit_customer']);
        Permission::create(['name' => 'delete_customer']);

        Permission::create(['name' => 'show_getdebt']);
        Permission::create(['name' => 'create_getdebt']);
        Permission::create(['name' => 'edit_getdebt']);
        Permission::create(['name' => 'delete_getdebt']);

        Permission::create(['name' => 'show_office']);
        Permission::create(['name' => 'create_office']);
        Permission::create(['name' => 'edit_office']);
        Permission::create(['name' => 'delete_office']);


        Permission::create(['name' => 'show_offdebt']);
        Permission::create(['name' => 'create_offdebt']);
        Permission::create(['name' => 'edit_offdebt']);
        Permission::create(['name' => 'delete_offdebt']);


        Permission::create(['name' => 'show_debtor']);
        Permission::create(['name' => 'create_debtor']);
        Permission::create(['name' => 'edit_debtor']);
        Permission::create(['name' => 'delete_debtor']);

        Permission::create(['name' => 'show_onlydebt']);
        Permission::create(['name' => 'create_onlydebt']);
        Permission::create(['name' => 'edit_onlydebt']);
        Permission::create(['name' => 'delete_onlydebt']);


        Permission::create(['name' => 'show_seller']);
        Permission::create(['name' => 'create_seller']);
        Permission::create(['name' => 'edit_seller']);
        Permission::create(['name' => 'delete_seller']);


        Permission::create(['name' => 'show_repdebt']);
        Permission::create(['name' => 'create_repdebt']);
        Permission::create(['name' => 'edit_repdebt']);
        Permission::create(['name' => 'delete_repdebt']);



        Role::create(['name' => 'admin'])
        ->givePermissionTo(
        'show_user',
        'create_user',
        'edit_user',
        'delete_user',

        'show_role',
        'create_role',
        'edit_role',
        'delete_role',

        'show_category',
        'create_category',
        'edit_category',
        'delete_category',

        'show_product',
        'create_product',
        'edit_product',
        'delete_product',

        'show_customer',
        'create_customer',
        'edit_customer',
        'delete_customer',

        'show_getdebt',
        'create_getdebt',
        'edit_getdebt',
        'delete_getdebt',


        'show_repdebt',
        'create_repdebt',
        'edit_repdebt',
        'delete_repdebt',



        'show_office',
        'create_office',
        'edit_office',
        'delete_office',


        'show_offdebt',
        'create_offdebt',
        'edit_offdebt',
        'delete_offdebt',


        'show_debtor',
        'create_debtor',
        'edit_debtor',
        'delete_debtor',


        'show_onlydebt',
        'create_onlydebt',
        'edit_onlydebt',
        'delete_onlydebt',


        'show_seller',
        'create_seller',
        'edit_seller',
        'delete_seller',
    );

    Role::create(['name' => 'moderator'])
    ->givePermissionTo(
    'show_user',
    'show_role',
);


    }
}
