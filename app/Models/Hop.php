<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hop extends Model
{
    protected $table = 'hop';
    protected $primaryKey = 'hopId';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['name'];

    public function beers(): BelongsToMany
    {
        return $this->belongsToMany(Beer::class, 'beer_hop', 'hopId', 'beerId', 'hopId', 'beerId');
    }
}
