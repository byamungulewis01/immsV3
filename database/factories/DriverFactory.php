<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'driving_license' => $this->faker->unique()->randomNumber(8),
            'driving_category' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'branch' => $this->faker->randomElement([1, 2, 3, 4]),
            'role' => $this->faker->randomElement(['admin', 'driver']),
        ];
    }
}
