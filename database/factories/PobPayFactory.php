<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PobPay>
 */
class PobPayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'box_id' => $this->faker->numberBetween(10, 30),
            'amount' => $this->faker->numberBetween(10000, 99999),
            'year' => $this->faker->numberBetween(2016, 2023),
            'payment_type' => $this->faker->randomElement(['rent', 'cert','key','cotion','ingufuri']),
            'payment_model' => $this->faker->randomElement(['mobile_money', 'bank','cash','cos']),
            'serviceType' => $this->faker->randomElement(['PBox', 'VBox']),
            'branch_id' =>  $this->faker->randomElement([1, 2, 3]),
            'payment_ref' =>$this->faker->uuid,
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
