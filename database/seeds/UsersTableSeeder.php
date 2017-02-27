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
        	'phone' => '0817138056',
        	'password' => bcrypt('password'),
        ];

        $user2 = [
            'fname' => 'Brian',
            'lname' => 'West',
            'phone' => '0912785432',
            'password' => bcrypt('password'),
        ];

        $user3 = [
            'fname' => 'Anabel',
            'lname' => 'Worsty',
            'phone' => '0621906743',
            'password' => bcrypt('password'),
        ];

        $user4 = [
            'fname' => 'Grindewald',
            'lname' => 'Ristique',
            'phone' => '0521906443',
            'password' => bcrypt('password'),
        ];

        $user5 = [
            'fname' => 'Albus',
            'lname' => 'Dumbledore',
            'phone' => '0921966743',
            'password' => bcrypt('password'),
        ];

        User::create($user1);
        User::create($user2);
        User::create($user3);
        User::create($user4);
        User::create($user5);
    }
}
