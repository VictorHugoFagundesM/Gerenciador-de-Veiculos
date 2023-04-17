<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert(
            [
                ['name' => 'Toyota'  ],
                ['name' => 'Volkswagen' ],
                ['name' => 'Hyundai-Kia'],
                ['name' => 'General Motors' ],
                ['name' => 'Ford' ],
                ['name' => 'Honda' ],
                ['name' => 'Nissan' ],
                ['name' => 'Mitsubishi' ],
                ['name' => 'Nissan' ],
                ['name' => 'Renault' ],
                ['name' => 'BMW' ],
                ['name' => 'Mercedes-Benz' ],
                ['name' => 'Suzuki' ],
                ['name' => 'Subaru' ],
                ['name' => 'Mitsubishi' ],
                ['name' => 'Yamaha' ],
                ['name' => 'Outra' ],
            ]
        );
    }
}
