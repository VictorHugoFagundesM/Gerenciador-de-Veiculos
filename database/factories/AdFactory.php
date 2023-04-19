<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand_id' => random_int(1,8),
            'vehicle_type_id' => random_int(1,8),
            'is_avaliable' => $this->faker->boolean(),
            'name' => $this->faker->name,
            'year' => "2010/2011",
            'color' => "Amarelo",
            'price_per_day' => "22.20",
            'informations' => $this->faker->text(1000),
            'begin_avaliable_date' => now(),
            'end_avaliable_date' => now(),
        ];
    }
}
