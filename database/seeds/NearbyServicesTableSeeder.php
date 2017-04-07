<?php

use Illuminate\Database\Seeder;
use App\Utility;
class NearbyServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Hospital',
            'Police',
            'Water services',
            'Public bus station',
            'Market',
            'Shops',
            'Electrical supply',
            'Primary school',
            'Secondary school'
        ];

        for($i = 0; $i < count($services); $i++){
            $service = [
                'name' => $services[$i],
            ];
            Utility::create($service);
        }
    }
}
