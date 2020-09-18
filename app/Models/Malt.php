<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Malt extends Model
{
    protected $table = 'malt';
    protected $primaryKey = 'maltId';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['name'];

    public function beers(): BelongsToMany
    {
        return $this->belongsToMany(Beer::class, 'beer_malt', 'maltId', 'beerId', 'maltId', 'beerId');
    }
}
