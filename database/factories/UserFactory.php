<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'role'              => 'user',
            'phone'             => fake()->phoneNumber(),
            'location'          => fake()->randomElement([
                'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang',
                'Makassar', 'Yogyakarta', 'Malang', 'Denpasar', 'Palembang',
            ]),
            'bio'               => fake()->sentence(8),
            'is_banned'         => false,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['role' => 'admin']);
    }

    public function banned(): static
    {
        return $this->state(fn () => ['is_banned' => true]);
    }
}
