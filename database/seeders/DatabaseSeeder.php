<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plat;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@restaurant.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Caissier',
            'email' => 'caissier@restaurant.com',
            'password' => bcrypt('password'),
            'role' => 'caissier'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Serveur',
            'email' => 'serveur@restaurant.com',
            'password' => bcrypt('password'),
            'role' => 'serveur'
        ]);
        $this->call(RolePermissionSeeder::class);
        
        // Création des ingrédients d'abord
        $pates = Ingredient::create([
            'nom' => 'Pâtes',
            'quantite_stock' => 1000,
            'unite' => 'g',
            'prix_unitaire' => 0.5
        ]);

        $lardons = Ingredient::create([
            'nom' => 'Lardons',
            'quantite_stock' => 500,
            'unite' => 'g',
            'prix_unitaire' => 1.2
        ]);

        $oeufs = Ingredient::create([
            'nom' => 'Œufs',
            'quantite_stock' => 12,
            'unite' => 'unité',
            'prix_unitaire' => 0.3
        ]);

        // Création du plat ensuite
        $carbonara = Plat::create([
            'nom_plat' => 'Spaghetti Carbonara',
            'quantite' => 1,
            'prix_unitaire' => 12.99
        ]);

        // Attachement des ingrédients au plat
        $carbonara->ingredients()->attach([
            $pates->id => ['quantite' => 200, 'unite' => 'g'],
            $lardons->id => ['quantite' => 150, 'unite' => 'g'],
            $oeufs->id => ['quantite' => 2, 'unite' => 'unité']
        ]);

        // Affichage de vérification
        $plat = Plat::with('ingredients')->first();

        foreach ($plat->ingredients as $ingredient) {
            echo "{$ingredient->nom}: {$ingredient->pivot->quantite}{$ingredient->pivot->unite}\n";
        }
    }
}