<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itineraie extends Model
{
    use HasFactory;

    protected $fillable = ['destination_id','origine_id','prix'];

    public function origine(): BelongsTo
    {
        return $this->belongsTo(Localite::class, 'origine_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Localite::class, 'destination_id');
    }
}
