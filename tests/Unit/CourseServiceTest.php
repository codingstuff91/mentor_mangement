<?php

use App\Services\CourseService;
use Carbon\Carbon;

it('Gets the hours count from the duration', function () {
    $duration = "01:00";

    $expectedHoursCount = CourseService::splitHoursOrMinutes($duration, 0);

    expect($expectedHoursCount)->toBe(1);
});

it('Gets the minutes count from the duration', function () {
    $duration = "01:30";

    $expectedHoursCount = CourseService::splitHoursOrMinutes($duration, 1);

    expect($expectedHoursCount)->toBe(30);
});

it('Computes the end hour of a course based on start hour and duration', function () {
    $startHourCourse = Carbon::parse('08:00');

    $courseDuration = "01:30";

    $endHourCourse = CourseService::computeEndHour($startHourCourse, $courseDuration);

    expect($endHourCourse)->toBe('09:30');
});
