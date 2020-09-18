<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Style extends Model
{
    protected $table = 'style';
    protected $primaryKey = 'styleId';
    public $timestamps = false;

    protected $fillable = ['name'];

    public function beers(): HasMany
    {
        return $this->hasMany(Beer::class, 'styleId', 'styleId');
    }
}
