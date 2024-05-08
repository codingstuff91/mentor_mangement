<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Console\Command;

class calculateCoursesPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:calculate-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean the courses table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            $course->price = CourseService::calculate_total_price($course->hours_count, $course->hourly_rate);

            $course->save();
        }

        return Command::SUCCESS;
    }
}
