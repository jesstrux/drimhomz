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
        // $user1 = [
        // 	'name' => 'James Wolpert',
        // 	'email' => 'wolpertjamie@gmail.com',
        // 	'password' => Hash::make('password'),
        // ];

        // $user2 = [
        //     'name' => 'Brian West',
        //     'email' => 'bwest@rocketmail.com',
        //     'password' => Hash::make('password'),
        // ];

        $user3 = [
            'name' => 'Anabel Worsty',
            'email' => 'anniety@yahoo.com',
            'password' => Hash::make('password'),
        ];

        // User::create($user1);
        User::create($user3);
    }
}
