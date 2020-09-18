<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Beer extends Model
{
    protected $table = 'beer';
    protected $primaryKey = 'beerId';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['name', 'styleId'];

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class, 'styleId', 'styleId');
    }

    public function hops(): BelongsToMany
    {
        return $this->belongsToMany(Hop::class, 'beer_hop', 'beerId', 'hopId');
    }

    public function yeasts(): BelongsToMany
    {
        return $this->belongsToMany(Yeast::class, 'beer_yeast', 'beerId', 'yeastId');
    }

    public function malts(): BelongsToMany
    {
        return $this->belongsToMany(Malt::class, 'beer_malt', 'beerId', 'maltId');
    }
}
