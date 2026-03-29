<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement([
                'Data Structures',
                'Algorithms',
                'Operating Systems',
                'Computer Networks',
                'Database Systems',
                'Artificial Intelligence',
                'Machine Learning',
                'Web Development',
                'Mobile Development',
                'Frontend Development',
                'Backend Development',
                'Full Stack Development',
                'DevOps',
                'Cybersecurity',
            ]),
            'description' => fake()->paragraph(),
        ];
    }
}
