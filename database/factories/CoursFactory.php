<?php

namespace Database\Factories;

use App\Models\Eleve;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'eleve_id' => Eleve::all()->random()->id,
            'facture_id' => Facture::all()->random()->id,
            'date_debut' => $this->faker->dateTimeThisYear(),
            'date_fin' => $this->faker->dateTimeThisYear(),
            'nombre_heures' => $this->faker->randomNumber(1,3),
            'taux_horaire' => $this->faker->numberBetween(30,40),
            'notions_apprises' => $this->faker->sentence(3),
            'paye' => $this->faker->boolean,            
        ];
    }
}
