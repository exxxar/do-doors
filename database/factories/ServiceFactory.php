<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Service;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'type' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'order_position' => $this->faker->numberBetween(-10000, 10000),
            'is_active' => $this->faker->boolean(),
            'price' => '{}',
        ];
    }
}
