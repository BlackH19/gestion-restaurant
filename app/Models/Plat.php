<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plat extends Model
{
    use HasFactory;

    protected $fillable = ['nom_plat', 'prix_unitaire'];

    // Relation avec les commandes (pivot : commande_plat)
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_plat')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }

    // Relation avec les ingrédients (pivot : plat_ingredient)
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'plat_ingredient')
                    ->withPivot('quantite') // quantité utilisée par plat
                    ->withTimestamps();
    }
}
