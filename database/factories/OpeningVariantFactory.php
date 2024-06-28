<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\OpenVariant;

class OpeningVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OpenVariant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'order_position' => $this->faker->numberBetween(-10000, 10000),
            'price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'depth' => $this->faker->randomFloat(0, 0, 9999999999.),
            'direction' => $this->faker->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
