<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Yeast extends Model
{
    protected $table = 'yeast';
    protected $primaryKey = 'yeastId';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['name'];

    public function beers(): BelongsToMany
    {
        return $this->belongsToMany(Beer::class, 'beer_yeast', 'yeastId', 'beerId', 'yeastId', 'beerId');
    }
}
