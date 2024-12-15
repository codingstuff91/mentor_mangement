<?php

namespace App\Services;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceService
{
    public static function compute_total_price(Invoice $invoice): int
    {
        $courses = $invoice->courses;

        $total = 0;

        foreach ($courses as $course) {
            $timer = Carbon::parse($course->hours_count);

            // Calculer le total des heures au format float
            $totalHoursFloat = $timer->hour + ($timer->minute / 60.0);

            $total += $totalHoursFloat * $course->hourly_rate;
        }

        return $total;
    }

    public static function compute_total_hours(Invoice $invoice): string
    {
        $courses = $invoice->courses;

        $total = Carbon::parse('00:00');

        foreach ($courses as $course) {
            $total->addHours(Carbon::parse($course->hours_count)->hour);
            $total->addMinutes(Carbon::parse($course->hours_count)->minute);
        }

        return $total->format('H:i');
    }
}
