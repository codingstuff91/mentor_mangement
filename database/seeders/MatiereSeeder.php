<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::create([
            'nom' => 'Excel'
        ]);

        Subject::create([
            'nom' => 'Html/css'
        ]);

        Subject::create([
            'nom' => 'Laravel'
        ]);

    }
}
