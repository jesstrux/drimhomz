<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'admin',
                'display_name' => 'System Administrator',
                'description' => 'System Admin can perform system level tasks'
            ],
            [
                'name' => 'seller',
                'display_name' => 'Seller/Realtor',
                'description' => 'User can view,create,edit and delete shops'
            ],
            [
                'name' => 'expert',
                'display_name' => 'User Expert',
                'description' => 'User can create articles in addition to user roles'
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'User can login, like, comment, drim, create a house'
            ]

        ];

        foreach ($role as $key => $value) {
            Role::create($value);
        }
    }
}
