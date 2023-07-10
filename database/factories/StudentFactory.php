<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => $this->faker->name(),
            'goals'    => $this->faker->sentence(3),
            'comments' => $this->faker->sentence(3),
        ];
    }
}
