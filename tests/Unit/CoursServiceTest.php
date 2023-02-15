<?php

namespace Tests\Unit;

use Carbon\Carbon;
use App\Models\Cours;
use App\Services\CoursService;
use PHPUnit\Framework\TestCase;

class CoursServiceTest extends TestCase
{
    public function test_count_lesson_hours_return_the_course_duration_in_hours()
    {
        $startHour = Carbon::now();
        $startHour->hour = 18;
        $startHour->minute = 00;

        $endHour = Carbon::now();
        $endHour->hour = 19;
        $endHour->minute = 00;
        
        $coursService = new CoursService();

        $this->assertEquals(1, $coursService->count_lesson_hours($endHour->hour,$startHour->hour));
    }
}
