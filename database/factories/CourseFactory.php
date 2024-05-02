<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Invoice;
use App\Services\CourseService;
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
        $startHour = Carbon::parse('10:00');
        $endHour = Carbon::parse('11:00');

        return [
            'student_id' => Student::all()->random()->id,
            'invoice_id' => Invoice::all()->random()->id,
            'date' => now()->format('Y-m-d'),
            'start_hour' => $startHour,
            'end_hour' => $endHour,
            'hours_count' => '01:00',
            'hourly_rate' => 10,
            'price' => CourseService::calculate_total_price("01:00", 10),
            'learned_notions' => $this->faker->sentence(3),
            'paid' => $this->faker->boolean,
        ];
    }
}
