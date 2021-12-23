<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'nom' => 'Superprof',
            'commentaires' => 'Plateforme mise en relation eleve et prof'
        ]);
        
        Client::create([
            'nom' => 'Orformat',
            'commentaires' => 'Organisme de formation utilisant le CPF'
        ]);
    }
}
