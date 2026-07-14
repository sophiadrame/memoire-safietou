<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@groupeisi.edu',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Enseignants
        $enseignants = [
            ['name' => 'Dr. Babacar Drame', 'email' => 'b.drame@groupeisi.edu'],
            ['name' => 'Pr. Seny Mbaye',    'email' => 's.mbaye@groupeisi.edu'],
            ['name' => 'Dr. Khady Sall',    'email' => 'k.sall@groupeisi.edu'],
            ['name' => 'Mactar Thioye',     'email' => 'm.thioye@groupeisi.edu'],
            ['name' => 'Mouhamadan Lô',     'email' => 'm.lo@groupeisi.edu'],
        ];
        foreach ($enseignants as $e) {
            User::create(array_merge($e, [
                'password' => Hash::make('password'),
                'role'     => 'enseignant',
            ]));
        }

        // Étudiants
        $etudiants = [
            ['name' => 'Safietou Drame', 'email' => 'dramesophia30@gmail.com'],
            ['name' => 'Aicha Dia',      'email' => 'a.dia@groupeisi.edu'],
            ['name' => 'astou niang',        'email' => 'astou.nang@groupeisi.edu'],
        ];
        foreach ($etudiants as $e) {
            User::create(array_merge($e, [
                'password' => Hash::make('password'),
                'role'     => 'etudiant',
            ]));
        }
    }
}