<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Services\CourseService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class reformat_hours_count_into_duration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:regul-hours-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move the hours count value into new duration column';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            $time = Carbon::parse('00:00');

            $hoursCount = $course->hours_count;

            $time->hour = $hoursCount;

            $course->duration = $time;
        }

        return Command::SUCCESS;
    }
}
