<?php

namespace Database\Seeders;

use App\Models\Matiere;
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
        Matiere::create([
            'nom' => 'Excel'
        ]);
        
        Matiere::create([
            'nom' => 'Html/css'
        ]);
        
        Matiere::create([
            'nom' => 'Laravel'
        ]);
        
    }
}
