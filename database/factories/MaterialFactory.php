<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Material;

class MaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Material::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $wrapper_variants = [];

        for ($i = 0; $i < random_int(5, 15); $i++)
            $wrapper_variants[] = (object)[
                "uuid"=>Str::uuid(),
                "image" => $this->faker->imageUrl(),
                "title" => $this->faker->text(50),
                "description" => $this->faker->text(50),
            ];

        $door_variants = [];

        for ($i = 0; $i < random_int(5, 15); $i++)
            $door_variants[] = (object)[
                "uuid"=>Str::uuid(),
                "image" => $this->faker->imageUrl(),
                "title" => $this->faker->text(50),
                "description" => $this->faker->text(50),
            ];


        return [
            'title' => $this->faker->sentence(4),
            'wrapper_variants' => $wrapper_variants,
            'door_variants' => $door_variants,
        ];
    }
}
