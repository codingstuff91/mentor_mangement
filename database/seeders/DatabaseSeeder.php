<?php

namespace Database\Seeders;

use App\Models\Cours;
use App\Models\Eleve;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Matiere;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\MatiereSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::factory(3)->create()->each(function($client){
            Facture::factory()->create([
                'client_id' => $client->id,
            ]);
        });

        Matiere::factory(5)->create()->each(function($matiere) use ($clients){
            Eleve::factory()->count(2)->create([
                'client_id' => $clients->random()->id,
                'matiere_id' => $matiere->id
            ])->each(function($eleve){
                Cours::factory(2)->create([
                    'eleve_id' => $eleve->id,
                    'facture_id' => Facture::all()->random()->id
                ]);
            });
        });

        $this->call(UserSeeder::class);
    }
}
