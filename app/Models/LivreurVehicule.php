<?php

namespace App\Models;

use App\Filament\Pages\Livreur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LivreurVehicule extends Model
{
    use HasFactory;

    protected $fillable = ['livreur_id','vehicule_id'];


    public function livreur(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicule(): BelongsTo
    {
        return  $this->belongsTo(Vehicule::class);
    }


    public function pendingLivraisons(): HasMany
    {
        return $this->hasMany(Livraison::class, 'attribution_id')
            ->currentStatus(['recupere']);
    }

}
