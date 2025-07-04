<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plat extends Model
{
    use HasFactory;

    protected $fillable = ['nom_plat', 'quantite','prix_unitaire'];

    public function commandes() {
        return $this->belongsToMany(Commande::class, 'commande_plat')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}
