<?php

namespace App\Http\Controllers;

use App\Models\Beer;
use Illuminate\Http\Request;

class BeerController
{
    public function index()
    {
        $beers = Beer::with(['style', 'hops', 'yeasts', 'malts'])->get();

        return view('beers.index', compact('beers'));
    }
}
