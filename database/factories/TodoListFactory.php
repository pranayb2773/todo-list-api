<?php

namespace Database\Factories;

use App\Enums\TodoListPriorities;
use App\Enums\TodoListStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\TodoList>
 */
class TodoListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->words(3, true),
            'description' => $this->faker->realText(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => TodoListStatus::Pending->value,
            'priority' => TodoListPriorities::Low->value,
            'user_id' => User::inRandomOrder()->first()->id
        ];
    }
}
