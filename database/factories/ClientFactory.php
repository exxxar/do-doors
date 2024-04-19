<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\User;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'phone' => $this->faker->phoneNumber(),
            'fax' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'email' => $this->faker->safeEmail(),
            'fact_address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'fact_address_comment' => $this->faker->text(),
            'comment' => $this->faker->text(),
            'code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'external_code' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'law_address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'inn' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'kpp' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'ogrn' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'okpo' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'requisites' => '{}',
        ];
    }
}
