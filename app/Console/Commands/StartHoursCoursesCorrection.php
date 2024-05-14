<?php

namespace App\Console\Commands;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StartHoursCoursesCorrection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:fix_start_hours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            $endHour = Carbon::parse($course->end_hour);

            $course->start_hour = $endHour->subHours($course->hours_count);

            $course->save();
        }

        return Command::SUCCESS;
    }
}
