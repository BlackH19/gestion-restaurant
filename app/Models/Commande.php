<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['date_heure', 'statut', 'total', 'serveur_id'];

    public function serveur() {
        return $this->belongsTo(User::class, 'serveur_id');
    }
    // ✅ Ajoute ceci :
    protected $casts = [
        'date_heure' => 'datetime',
    ];

    public function plats() {
        return $this->belongsToMany(Plat::class, 'commande_plat')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }

    public function calculerTotal() {
        $total = 0;
        foreach ($this->plats as $plat) {
            $total += $plat->prix_unitaire * $plat->pivot->quantite;
        }
        $this->total = $total;
        $this->save();
    }
}
