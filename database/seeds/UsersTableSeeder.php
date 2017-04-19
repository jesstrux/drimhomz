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
        	'fname' => 'James',
            'lname' => 'Wolpert',
        	'phone' => '0717138051',
        	'password' => Hash::make('password'),
            'email' => 'wolpert@owden.home',
            'dp' => "james.jpeg",

        ];

        $user2 = [
            'fname' => 'Dean',
            'lname' => 'Thomas',
            'phone' => '0717138052',
            'email' => 'dean@owden.home',
            'password' => Hash::make('password'),
            'dp' => "dean.jpg",

        ];

        $user3 = [
            'fname' => 'Anabel',
            'lname' => 'Worsty',
            'phone' => '0717138053',
            'email' => 'anabel@owden.home',
            'password' => Hash::make('password'),
            'dp' => "anna.jpg",

        ];

        $user4 = [
            'fname' => 'Kingsley',
            'lname' => 'ShackleBolt',
            'phone' => '0717138054',
            'email' => 'kingsley@owden.home',
            'password' => Hash::make('password'),
            'dp' => "kingsley.jpg",

        ];

        $user5 = [
            'fname' => 'Walter',
            'lname' => 'Kimaro',
            'phone' => '0717138056',
            'email' => 'walter@owden.home',
            'password' => Hash::make('password'),
            'dp' => "wallie.jpg",
            'role' => 'admin',

        ];

        User::create($user1);
        User::create($user2);
        User::create($user3);
        User::create($user4);
        User::create($user5);
    }
}
