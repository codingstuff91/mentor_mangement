<?php

namespace Tests\Unit;

use App\Exceptions\InvalidCourseHoursOrderException;
use App\Services\CoursService;
use PHPUnit\Framework\TestCase;

class CoursServiceTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideRawHours
     */
    public function can_return_the_hour_of_a_formated_hour($rawHour, $expectedResult)
    {
        $coursService = new CoursService();
        $coursService->getHour($rawHour);

        $this->assertEquals($expectedResult, $coursService->getHour($rawHour));
    }

    /**
     * @test
     * @dataProvider provideStartandEndhours
     */
    public function it_returns_the_course_duration_in_hours($startHour, $endHour, $expectedResult)
    {
        $coursService = new CoursService();

        $this->assertEquals($expectedResult, $coursService->count_lesson_hours($endHour,$startHour));
    }

    /** @test */
    public function it_throws_an_exception_if_course_hours_order_is_incorrect()
    {
        $this->expectException(InvalidCourseHoursOrderException::class);

        $startHour = 20;
        $endHour = 18;

        $coursService = new CoursService();
        $coursService->count_lesson_hours($endHour, $startHour);
    }

    public function provideStartandEndhours()
    {
        return [
            "Should return 1 hour" => [
                18, 19, 1
            ],
            "Should return 2 hours" => [
                18, 20, 2
            ],
            "Should return 3 hours" => [
                17, 20, 3
            ],
        ];
    }

    public function provideRawHours()
    {
        return [
            "Should return 18" => [
                "18:00", 18
            ],
            "Should return 19" => [
                "19:00", 19
            ],
            "Should return 20" => [
                "20:00", 20
            ],
        ];
    }
}
