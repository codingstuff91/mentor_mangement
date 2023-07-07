<?php

namespace App\Services;

use App\Exceptions\InvalidCourseHoursOrderException;

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

    /**
     * @param string $rawHour
     * @return int
     */
    public function getHour(string $rawHour): int
    {
        return explode(":", $rawHour)[0];
    }
}
