<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_types')->insert(
            [
                ['name' => 'Carro' ],
                ['name' => 'SUV' ],
                ['name' => 'Caminhão' ],
                ['name' => 'Ônibus' ],
                ['name' => 'Moto' ],
                ['name' => 'Bicicleta' ],
                ['name' => 'Barco' ],
                ['name' => 'Lancha' ],
                ['name' => 'Helicóptero' ],
                ['name' => 'Outro' ],
            ]
        );
    }
}
