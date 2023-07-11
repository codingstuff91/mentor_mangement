<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Invoice;
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
            'invoice_id' => Invoice::all()->random()->id,
            'date' => now(),
            'start_hour' => $startHour,
            'end_hour' => $endHour,
            'hours_count' => $coursService->count_lesson_hours($endHour->hour,$startHour->hour),
            'hourly_rate' => 10,
            'learned_notions' => $this->faker->sentence(3),
            'paid' => $this->faker->boolean,
        ];
    }
}
