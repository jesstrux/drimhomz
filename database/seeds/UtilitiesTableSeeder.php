<?php

use Illuminate\Database\Seeder;
use App\Utility;
class UtilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $utilities = [
            [
                'name' => 'Bedroom',
                'type' => 'room'
            ],
            [
                'name' => 'Bedroom with bathroom',
                'type' => 'room'
            ],
            [
                'name' => 'Bedroom with bathroom and dressing room',
                'type' => 'room'
            ],
            [
                'name' => 'Baby room',
                'type' => 'room'
            ],
            [
                'name' => 'Living room',
                'type' => 'room'
            ],
            [
                'name' => 'Dining room',
                'type' => 'room'
            ],
            [
                'name' => 'Study room',
                'type' => 'room'
            ],
            [
                'name' => 'Meditation room',
                'type' => 'room'
            ],
            [
                'name' => 'Laundry room',
                'type' => 'room'
            ],
            [
                'name' => 'Multipurpose room',
                'type' => 'room'
            ],
            [
                'name' => 'Pet room',
                'type' => 'room'
            ],
            [
                'name' => 'Kitchen',
                'type' => 'room'
            ],
            [
                'name' => 'Store',
                'type' => 'room'
            ],
            [
                'name' => 'Public toilet',
                'type' => 'room'
            ],
            [
                'name' => 'Public bathroom',
                'type' => 'room'
            ],
            [
                'name' => 'Fully furnished',
                'type' => 'feature'
            ],
            [
                'name' => 'Air condition',
                'type' => 'feature'
            ],
            [
                'name' => 'Car parking',
                'type' => 'feature'
            ],
            [
                'name' => 'Electricity',
                'type' => 'feature'
            ],
            [
                'name' => 'Water Supply',
                'type' => 'feature'
            ],
            [
                'name' => 'Heating system',
                'type' => 'feature'
            ],
            [
                'name' => 'Garage',
                'type' => 'feature'
            ],
            [
                'name' => 'Fence',
                'type' => 'feature'
            ],
            [
                'name' => 'Garden',
                'type' => 'feature'
            ],
            [
                'name' => 'Balcony',
                'type' => 'feature'
            ],
            [
                'name' => 'Movie theatre',
                'type' => 'feature'
            ],
            [
                'name' => 'Gym',
                'type' => 'feature'
            ]
        ];

        for($i = 0; $i < count($utilities); $i++){
            $utility = [
                'name' => $utilities[$i]['name'],
                'type' => $utilities[$i]['type'],
            ];
            Utility::create($utility);
        }
    }
}
