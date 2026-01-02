<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('etat')->insert([
    ['etat'=>'En cours'],
    ['etat'=>'Terminé'],
    ['etat'=>'En attente'],
    ['etat'=>'Archivé']
]);

    }

}
