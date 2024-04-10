<?php

namespace Tests\Factories;

use App\Models\Invoice;
use App\Models\Student;

class CourseRequestDataFactory
{
    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): array
    {
        return $extra + [
            'student' => Student::first()->id,
            'invoice' => Invoice::first()->id,
            "start_hour" => "18:00",
            "end_hour" => "19:00",
            'date' => "2023-07-01",
            'learned_notions' => "description des notions",
            'hourly_rate' => 50,
        ];
    }
}
