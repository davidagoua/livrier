<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\ModelStatus\HasStatuses;

class Livraison extends Model
{
    use HasFactory, HasStatuses;

    protected $casts = [
        'description'=>'array'
    ];
    protected $fillable = [
        'itineraie_id',"attribution_id",
        "description","colis","client_id",
        "state"
    ];


    public function itineraie(): BelongsTo
    {
        return $this->belongsTo(Itineraie::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function attribution(): BelongsTo
    {
        return $this->belongsTo(LivreurVehicule::class, 'attribution_id')->with('livreur','vehicule');
    }

    public function state(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value($this)
        );
    }
}
