<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Handle;

class HandleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Handle::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(50),
            'price' => $this->faker->randomFloat(0, 0, 999.),
            'variants' => [$this->faker->imageUrl()],
        ];
    }
}
