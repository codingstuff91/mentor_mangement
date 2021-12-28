<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

class EleveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(),
            'matiere_id' => Matiere::first()->id,
            'client_id' => Client::first()->id,
            'objectifs' => $this->faker->sentence(3),
            'commentaires' => $this->faker->sentence(3),
        ];
    }
}
