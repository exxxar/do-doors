<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PromoCode;

class PromoCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PromoCode::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'discount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'description' => $this->faker->text(),
            'end_at' => $this->faker->dateTime(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
