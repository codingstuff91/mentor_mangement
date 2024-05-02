<?php

namespace App\Services;

use Carbon\Carbon;

class CourseService
{
    public static function computeEndHour(string $startHour, string $duration): string
    {
        $hoursToAdd = CourseService::splitHoursOrMinutes($duration, 0);
        $minutesToAdd = CourseService::splitHoursOrMinutes($duration, 1);

        $endHour = Carbon::parse($startHour);

        $endHour->add('hour', $hoursToAdd);
        $endHour->add('minute', $minutesToAdd);

        return $endHour->format('H:i');
    }

    public static function splitHoursOrMinutes(string $duration, int $item): int
    {
        return explode(':', $duration)[$item];
    }

    public static function calculate_total_price(string $duration, int $hourlyRate): float
    {
        $hoursCount = Carbon::parse($duration)->hour + (Carbon::parse($duration)->minute / 60);

        return $hoursCount * $hourlyRate;
    }
}
