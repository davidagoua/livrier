<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Localite extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','kilo'
    ];

    public function destinations(): HasMany
    {
        return $this->hasMany(Itineraie::class, 'origine_id');
    }

    public function origines(): HasMany
    {
        return $this->hasMany(Itineraie::class, 'destination_id');
    }
}
