<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MouvementCaisse extends Model
{
    //
    use HasFactory;

    protected $fillable = ['type', 'montant', 'motif', 'caissier_id'];

    public function caissier() {
        return $this->belongsTo(User::class, 'caissier_id');
    }
    public static function getSoldeActuel()
{
    $entrees = self::where('type', 'entree')->sum('montant');
    $sorties = self::where('type', 'sortie')->sum('montant');
    return $entrees - $sorties;
}
    public static function entreesDuJour()
    {
        return self::where('type', 'entree')->whereDate('created_at', today())->sum('montant');
    }

    public static function sortiesDuJour()
    {
        return self::where('type', 'sortie')->whereDate('created_at', today())->sum('montant');
    }
}
