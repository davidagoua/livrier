<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicule extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','matricule'
    ];

    public function attribution(): HasMany
    {
        return $this->hasMany(LivreurVehicule::class, 'vehicule_id');
    }
}
