<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Customer;
use App\Models\Student;
use App\Models\Invoice;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::factory(3)->create()->each(function($customer){
            Invoice::factory()->create([
                'customer_id' => $customer->id,
            ]);
        });

        Subject::factory(5)->create()->each(function($subject) use ($customers){
            Student::factory()->create([
                'customer_id' => $customers->random()->id,
                'subject_id' => $subject->id
            ])->each(function($student){
                Course::factory(3)->create([
                    'student_id' => $student->id,
                    'invoice_id' => Invoice::first()->id
                ]);
            });
        });

        $this->call(UserSeeder::class);
    }
}
