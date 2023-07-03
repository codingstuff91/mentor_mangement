<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Facture;
use App\Services\CoursService;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startHour = Carbon::now();
        $startHour->hour = 18;
        $startHour->minute = 00;

        $endHour = Carbon::now();
        $endHour->hour = 19;
        $endHour->minute = 00;

        $coursService = new CoursService();

        return [
            'student_id' => Student::all()->random()->id,
            'facture_id' => Facture::all()->random()->id,
            'date_debut' => $startHour,
            'date_fin' => $endHour,
            'nombre_heures' => $coursService->count_lesson_hours($endHour->hour,$startHour->hour),
            'taux_horaire' => 50,
            'notions_apprises' => $this->faker->sentence(3),
            'paye' => $this->faker->boolean,
        ];
    }
}
