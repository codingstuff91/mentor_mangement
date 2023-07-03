<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Customer;
use App\Models\Student;
use App\Models\Facture;
use App\Models\Matiere;
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
            Facture::factory()->create([
                'customer_id' => $customer->id,
            ]);
        });

        Matiere::factory(5)->create()->each(function($matiere) use ($customers){
            Student::factory()->create([
                'customer_id' => $customers->random()->id,
                'matiere_id' => $matiere->id
            ])->each(function($student){
                Course::factory(3)->create([
                    'student_id' => $student->id,
                    'facture_id' => Facture::first()->id
                ]);
            });
        });

        $this->call(UserSeeder::class);
    }
}
