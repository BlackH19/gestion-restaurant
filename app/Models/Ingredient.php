<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'quantite_stock', 'unite', 'prix_unitaire'];

    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'plat_ingredient')
            ->withPivot('quantite')
            ->withTimestamps();
    }

    public function scopeDisponible($query)
    {
        return $query->where('quantite_stock', '>', 0);
    }
}