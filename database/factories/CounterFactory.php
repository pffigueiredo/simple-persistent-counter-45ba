<?php

namespace Database\Factories;

use App\Models\Counter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Counter>
 */
class CounterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Counter>
     */
    protected $model = Counter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'count' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Indicate that the counter should start at zero.
     */
    public function zero(): static
    {
        return $this->state(fn (array $attributes) => [
            'count' => 0,
        ]);
    }
}