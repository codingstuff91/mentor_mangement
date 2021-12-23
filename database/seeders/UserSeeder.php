<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nom' => 'Matthieu',
            'email' => 'codingstuff91@gmail.com',
            'password' => bcrypt('Fnp90std@'),
        ]);
    }
}
