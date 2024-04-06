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
     * @throws \Exception
     */
    public function definition(): array
    {
        $variants = [];

        for ($i = 0; $i < random_int(2, 15); $i++)
            $variants[] = (object)[
                "uuid"=>Str::uuid(),
                "image" => $this->faker->imageUrl(),
                "title" => $this->faker->text(50),
                "description" => $this->faker->text(50),
            ];

        return [
            'title' => $this->faker->text(50),
            'price' => $this->faker->randomFloat(0, 0, 999.),
            'color' => $this->faker->hexColor(),
            'variants' => $variants,
        ];
    }
}
