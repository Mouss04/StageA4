<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime toutes les données existantes
        DB::table('users')->delete();

        // Réinitialise l'auto-incrémentation
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');

        // Ajoute les nouvelles entrées
        DB::table('users')->insert([
            [
                'nom_complet' => 'Admin User',
                'surnom' => 'admin',
                'email' => 'admin@example.com',
                'motdepasse' => Hash::make('password'), // Utilise la classe Hash pour hacher le mot de passe
                'photo' => null,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_complet' => 'Orateur User',
                'surnom' => 'orateur',
                'email' => 'orateur@example.com',
                'motdepasse' => Hash::make('password'),
                'photo' => null,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'orateur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_complet' => 'Sponsor User',
                'surnom' => 'sponsor',
                'email' => 'sponsor@example.com',
                'motdepasse' => Hash::make('password'),
                'photo' => null,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'sponsor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom_complet' => 'Visiteur User',
                'surnom' => 'visiteur',
                'email' => 'visiteur@example.com',
                'motdepasse' => Hash::make('password'),
                'photo' => null,
                'email_verified_at' => null,
                'remember_token' => Str::random(10),
                'role' => 'visiteur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
