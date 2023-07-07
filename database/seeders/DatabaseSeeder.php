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
    private const NUMBER_OF_CUSTOMERS = 5;
    private const NUMBER_OF_SUBJECTS = 5;
    private const NUMBER_OF_STUDENTS_PER_SUBJECT = 1;
    private const NUMBER_OF_COURSES_PER_STUDENT = 1;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seedCustomers();
        $this->seedSubjects();
        $this->seedStudentsAndCourses();
        $this->seedUser();
    }
    private function seedCustomers()
    {
        Customer::factory(self::NUMBER_OF_CUSTOMERS)
            ->has(Invoice::factory()->unpaid())
            ->create();
    }
    private function seedSubjects()
    {
        Subject::factory(self::NUMBER_OF_SUBJECTS)->create();
    }
    private function seedStudentsAndCourses()
    {
        $customers = Customer::all();
        $subjects = Subject::all();

        $subjects->each(function ($subject) use ($customers) {
            $students = Student::factory(self::NUMBER_OF_STUDENTS_PER_SUBJECT)->create([
                'customer_id' => $customers->random()->id,
                'subject_id' => $subject->id,
            ]);

            $students->each(function ($student) {
                $invoiceId = Invoice::all()->random()->id;

                Course::factory(self::NUMBER_OF_COURSES_PER_STUDENT)->create([
                    'student_id' => $student->id,
                    'invoice_id' => $invoiceId,
                ]);
            });
        });
    }
    private function seedUser()
    {
        $this->call(UserSeeder::class);
    }
}
