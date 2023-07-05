<?php

namespace Tests\Unit;

use Carbon\Carbon;
use App\Models\Course;
use App\Services\CoursService;
use PHPUnit\Framework\TestCase;

class CoursServiceTest extends TestCase
{
    /** @test */
    public function it_returns_the_course_duration_in_hours()
    {
        $startHour = Carbon::createFromTime(18, 0);
        $endHour = Carbon::createFromTime(19, 0);

        $coursService = new CoursService();

        $this->assertEquals(1, $coursService->count_lesson_hours($endHour->hour,$startHour->hour));
    }
}
