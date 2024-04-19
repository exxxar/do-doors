<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\Order;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'contract_number' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'contract_date' => $this->faker->dateTime(),
            'completion_at' => $this->faker->dateTime(),
            'client_id' => Client::factory(),
            'status' => $this->faker->numberBetween(-10000, 10000),
            'source' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'contact_person' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'phone' => $this->faker->phoneNumber(),
            'organizational_form' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'contract_amount' => $this->faker->randomFloat(0, 0, 9999999999.),
            'paid' => $this->faker->randomFloat(0, 0, 9999999999.),
            'debt' => $this->faker->randomFloat(0, 0, 9999999999.),
            'profit' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
