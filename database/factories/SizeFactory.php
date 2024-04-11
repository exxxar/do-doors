<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Size;
use App\Models\User;

class SizeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Size::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'width' => $this->faker->numberBetween(800, 1000),
            'height' => $this->faker->numberBetween(2100, 3000),
            'material_id' => Material::query()->get()->random()->id,
            'price' => (object)[
                "wholesale"=>$this->faker->randomFloat(0, 1000, 10000.),
                "dealer"=>$this->faker->randomFloat(0, 1000, 10000.),
                "retail"=>$this->faker->randomFloat(0, 1000, 10000.),
                "cost"=>$this->faker->randomFloat(0, 1000, 10000.),
            ],
            'price_koef' => $this->faker->randomFloat(0, 1.1, 1.9),
            'loops_count' => $this->faker->numberBetween(2, 4),
        ];
    }
}
