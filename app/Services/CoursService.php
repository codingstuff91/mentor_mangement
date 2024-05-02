<?php

namespace App\Services;

use App\Exceptions\InvalidCourseHoursOrderException;
use Carbon\Carbon;

class CoursService
{
    /**
     * @param string $rawEndHour
     * @param string $rawStartHour
     * @return int
     * @throws \Throwable
     */
    public function count_lesson_hours(string $rawEndHour, string $rawStartHour): int
    {
        $startHour = $this->getHour($rawStartHour);
        $endHour = $this->getHour($rawEndHour);

        throw_if($endHour < $startHour || $startHour > $endHour, InvalidCourseHoursOrderException::class);

        return $endHour - $startHour;
    }

    public static function computeEndHour(string $startHour, string $duration)
    {
        $hoursToAdd = CoursService::splitHoursOrMinutes($duration, 0);
        $minutesToAdd = CoursService::splitHoursOrMinutes($duration, 1);

        $endHour = Carbon::parse($startHour);

        $endHour->add('hour', $hoursToAdd);
        $endHour->add('minute', $minutesToAdd);

        return $endHour->format('H:i');
    }

    public static function splitHoursOrMinutes(string $duration, int $item): int
    {
        return explode(':', $duration)[$item];
    }
}
