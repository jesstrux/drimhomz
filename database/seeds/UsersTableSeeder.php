<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
        	'name' => 'James Wolpert',
        	'phone' => '0817138056',
        	'password' => Hash::make('password'),
        ];

        $user2 = [
            'name' => 'Brian West',
            'phone' => '0912785432',
            'password' => Hash::make('password'),
        ];

        $user3 = [
            'name' => 'Anabel Worsty',
            'phone' => '0621906743',
            'password' => Hash::make('password'),
        ];

        User::create($user1);
        User::create($user2);
        User::create($user3);
    }
}
