<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load all the JSON data files
        $stylesData = json_decode(file_get_contents(database_path('seeders/data/styles.json')), true);
        $beersData = json_decode(file_get_contents(database_path('seeders/data/beers.json')), true);
        $hopsData = json_decode(file_get_contents(database_path('seeders/data/hops.json')), true);
        $yeastsData = json_decode(file_get_contents(database_path('seeders/data/yeasts.json')), true);
        $maltsData = json_decode(file_get_contents(database_path('seeders/data/malts.json')), true);
        $beerHopsData = json_decode(file_get_contents(database_path('seeders/data/beer_hops.json')), true);
        $beerYeastsData = json_decode(file_get_contents(database_path('seeders/data/beer_yeasts.json')), true);
        $beerMaltsData = json_decode(file_get_contents(database_path('seeders/data/beer_malts.json')), true);

        // Insert styles
        foreach ($stylesData as $style) {
            DB::table('style')->insert([
                'styleId' => $style['styleId'],
                'name' => $style['name'],
                'description' => $style['description'],
            ]);
        }
        $this->command->info('Inserted ' . count($stylesData) . ' styles');

        // Insert hops
        foreach ($hopsData as $hop) {
            DB::table('hop')->insert([
                'hopId' => $hop['hopId'],
                'name' => $hop['name'],
                'description' => $hop['description'],
                'countryOfOrigin' => $hop['countryOfOrigin'],
            ]);
        }
        $this->command->info('Inserted ' . count($hopsData) . ' hops');

        // Insert yeasts
        foreach ($yeastsData as $yeast) {
            DB::table('yeast')->insert([
                'yeastId' => $yeast['yeastId'],
                'name' => $yeast['name'],
                'description' => $yeast['description'],
                'yeastType' => $yeast['yeastType'],
                'yeastFormat' => $yeast['yeastFormat'],
            ]);
        }
        $this->command->info('Inserted ' . count($yeastsData) . ' yeasts');

        // Insert malts
        foreach ($maltsData as $malt) {
            DB::table('malt')->insert([
                'maltId' => $malt['maltId'],
                'name' => $malt['name'],
                'description' => $malt['description'],
                'countryOfOrigin' => $malt['countryOfOrigin'],
            ]);
        }
        $this->command->info('Inserted ' . count($maltsData) . ' malts');

        // Insert beers
        foreach ($beersData as $beer) {
            DB::table('beer')->insert([
                'beerId' => $beer['beerId'],
                'styleId' => $beer['styleId'],
                'name' => $beer['name'],
                'abv' => $beer['abv'],
                'ibu' => $beer['ibu'],
                'isOrganic' => $beer['isOrganic'],
                'year' => $beer['year'],
            ]);
        }
        $this->command->info('Inserted ' . count($beersData) . ' beers');

        // Insert beer-hop relationships
        foreach ($beerHopsData as $beerHop) {
            DB::table('beer_hop')->insert([
                'beerId' => $beerHop['beerId'],
                'hopId' => $beerHop['hopId'],
            ]);
        }
        $this->command->info('Inserted ' . count($beerHopsData) . ' beer-hop relationships');

        // Insert beer-yeast relationships
        foreach ($beerYeastsData as $beerYeast) {
            DB::table('beer_yeast')->insert([
                'beerId' => $beerYeast['beerId'],
                'yeastId' => $beerYeast['yeastId'],
            ]);
        }
        $this->command->info('Inserted ' . count($beerYeastsData) . ' beer-yeast relationships');

        // Insert beer-malt relationships
        foreach ($beerMaltsData as $beerMalt) {
            DB::table('beer_malt')->insert([
                'beerId' => $beerMalt['beerId'],
                'maltId' => $beerMalt['maltId'],
            ]);
        }
        $this->command->info('Inserted ' . count($beerMaltsData) . ' beer-malt relationships');
    }
}
