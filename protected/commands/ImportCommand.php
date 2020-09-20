<?php

class ImportCommand extends CConsoleCommand
{
    public function actionImport()
    {
        Beer::model()->deleteAll();
        BeerHop::model()->deleteAll();
        BeerMalt::model()->deleteAll();
        BeerYeast::model()->deleteAll();
        Hop::model()->deleteAll();
        Malt::model()->deleteAll();
        Style::model()->deleteAll();
        Yeast::model()->deleteAll();

        for ($page = 1; $page <= 23; $page++) {
            $beers = $this->getBeers($page);

            if ($beers->status == 'success') {
                foreach ($beers->data as $beerObject) {
                    $beer = Beer::model()->findWithBeerId($beerObject->id);
                    if (!$beer) {
                        $beer = new Beer();
                        $beer->beerId = $beerObject->id;
                    }

                    $beer->name = $beerObject->name;
                    $beer->abv = $beerObject->abv;
                    $beer->isOrganic = ($beerObject->isOrganic === 'Y') ? true : false;
                    $beer->year = $beerObject->year;

                    if ($beerObject->style) {
                        $style = $this->styleForStyleObject($beerObject->style);

                        $beer->styleId = $style->styleId;
                    }

                    if ($beerObject->ingredients) {
                        if ($beerObject->ingredients->hops) {
                            foreach ($beerObject->ingredients->hops as $hopObject) {
                                $hop = $this->hopForHopObject($hopObject);

                                $beer->addHop($hop);
                            }
                        }

                        if ($beerObject->ingredients->yeast) {
                            foreach ($beerObject->ingredients->yeast as $yeastObject) {
                                $yeast = $this->yeastForYeastObject($yeastObject);

                                $beer->addYeast($yeast);
                            }
                        }

                        if ($beerObject->ingredients->malt) {
                            foreach ($beerObject->ingredients->malt as $maltObject) {
                                $malt = $this->maltForMaltObject($maltObject);

                                $beer->addMalt($malt);
                            }
                        }
                    }
                    
                    $beer->save();
                }
            }

            print_r($beers);
        }
    }

    private function styleForStyleObject($styleObject) {
        $style = Style::model()->findWithStyleId($styleObject->id);
        if (!$style) {
            $style = new Style();
            $style->styleId = $styleObject->id;
        }

        $style->name = $styleObject->name;
        $style->description = $styleObject->description;
        $style->save();

        return $style;
    }

    private function hopForHopObject($hopObject) {
        $hop = Hop::model()->findWithHopId($hopObject->id);
        if (!$hop) {
            $hop = new Hop();
            $hop->hopId = $hopObject->id;
        }

        $hop->name = $hopObject->name;
        $hop->description = $hopObject->description;
        $hop->countryOfOrigin = $hopObject->countryOfOrigin;
        $hop->save();

        return $hop;
    }

    private function yeastForYeastObject($yeastObject) {
        $yeast = Yeast::model()->findWithYeastId($yeastObject->id);
        if (!$yeast) {
            $yeast = new Yeast();
            $yeast->yeastId = $yeastObject->id;
        }

        $yeast->name = $yeastObject->name;
        $yeast->description = $yeastObject->description;
        $yeast->yeastType = $yeastObject->yeastType;
        $yeast->yeastFormat = $yeastObject->yeastFormat;
        $yeast->save();

        return $yeast;
    }

    private function maltForMaltObject($maltObject) {
        $malt = Malt::model()->findWithMaltId($maltObject->id);
        if (!$malt) {
            $malt = new Malt();
            $malt->maltId = $maltObject->id;
        }

        $malt->name = $maltObject->name;
        $malt->description = $maltObject->description;
        $malt->countryOfOrigin = $maltObject->countryOfOrigin;
        $malt->save();

        return $malt;
    }

    private function getBeers($page = 1)
    {
        $key = "3cabffbe9559e4ea1682a2addf2d944e";
        $url = "https://sandbox-api.brewerydb.com/v2/beers?p={$page}&withIngredients=Y&key={$key}";

        $handle = curl_init();
 
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($handle);
        curl_close($handle);

        return CJSON::decode($output, false);
    }
}
