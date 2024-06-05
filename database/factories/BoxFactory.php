<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Box>
 */
class BoxFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pob' => $this->faker->unique()->regexify('07[0-9]{8}'),
            'branch_id' => $this->faker->randomElement([1, 2, 3, 4 ,5 ,6 ,7 ,8 ,9 ,10]),
            'size' => $this->faker->randomElement(['Pte', 'Gde']),
            'status' => $this->faker->randomElement(['payee', 'impayee']),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->unique()->regexify('07[0-9]{8}'),
            'available' => $this->faker->boolean,
            'date' => $this->faker->date(),
            'pob_category' => $this->faker->randomElement(['Individual', 'Company', 'Association', 'Group']),
            'pob_type' => $this->faker->randomElement(['Individual', 'Company']),
            'amount' => $this->faker->numberBetween(1000, 9999),
            'year' => $this->faker->numberBetween(2018, 2023),
            'attachment' => $this->faker->imageUrl(),
            'customer_id' => $this->faker->numberBetween(1, 10),
            'aprooved' => $this->faker->boolean,
            'booked' => $this->faker->boolean,
            'cotion' => $this->faker->numberBetween(0, 3),
            'serviceType' =>  'VBox',

        ];
    }
}
