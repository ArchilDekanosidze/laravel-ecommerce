<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $slug = Str::slug($first_name, '-') . '-' . Str::slug($last_name, '-') . '-' . Str::random(5);

        return [
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $this->faker->numerify('##########'),
            // 'mobile' => '09120919921',
            'has_two_factor' => 0,
            'password' => Hash::make(1234),
            'social_security_number' => $this->faker->ssn,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'slug' => $slug,
            'profile_photo_path' => 'profile_photo_path',
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'activation' => 1,
            'activation_date' => now(),
            'user_type' => 0,
            'status' => 1,
            'remember_token' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverifiedEmail(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function unverifiedMobile(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'mobile_verified_at' => null,
            ];
        });
    }

    public function hasTwoFactor(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'has_two_factor' => 1,
            ];
        });
    }

    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => 1,
            ];
        });
    }
}
