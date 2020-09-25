<?php

class SiteController extends CController
{

    public function actionSearchBeer($name = null,
	    $style = null, 
	    $hop = null, 
	    $yeast = null, 
	    $malt = null,
	    $lastBeerId = null,
	    $firstPage = null,
	    $message = null
    )
    {
	//Pagination
	$beers = self::searchBeers($name, $style, $hop, $yeast, $malt, $lastBeerId);

	$this->render('search', compact('beers', 
					'name', 
					'style', 
					'hop', 
					'yeast', 
					'malt', 
					'firstPage',
					'message'));
    }

    public function actionSearch(
	    $name = null,
	    $style = null, 
	    $hop = null, 
	    $yeast = null, 
	    $malt = null,
	    $lastBeerId = null
    )
    {
	    $beers = self::searchBeers($name, $style, $hop, $yeast, $malt, $lastBeerId);
	    $result = self::formatForRest($beers, $name, $style, $hop, $yeast, $malt);
	    echo json_encode($result);
    }

    private static function formatForRest($beers, $name, $style, $hop, $yeast, $malt)
    {
	    $lastBeerId = null;
	    foreach($beers as $k => $beer){
		$lastBeerId = $k;
	    }


	    $args = [];
	    $args[] = "lastBeerId=$lastBeerId";
	    if($name){
		    $name = urlencode($name);
		    $args[] = "name=$name";
	    }
	    if($style){
		    $style = urlencode($style);
		    $args[] = "style=$style";
	    }
	    if($hop){
		    $style = urlencode($hop);
		    $args[] = "hop=$hop";
	    }
	    if($yeast){
		    $yeast = urlencode($yeast);
		    $args[] = "yeast=$yeast";
	    }
	    if($malt){
		    $malt = urlencode($malt);
		    $args[] = "malt=$malt";
	    }
	    $args = implode('&', $args);		
	    $nextPage = "/search?$args";

	    $result = [
		    'beers' => $beers,
		    '_links' => [
			'nextPage' => [
				'href' => $nextPage,
			],
		    ]
	    ];

	    return $result;
    }

    public function actionAddBeer()
    {
	$message = "";

	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$style = isset($_POST['style']) ? $_POST['style'] : null;

	if($name && $style){
		$result = self::addBeer($name, $style);
		if($result){
			$message = "Successfully added \"$name\"";
		} else {
			$message = "Error: Unable to add beer with name \"$name\"";
		}
	}

	$styles = Style::model()->findAll();
	$this->render('add', compact('styles', 'name', 'style', 'message')); 
    }

    public function actionAdd()
    {
	$message = "";

	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$style = isset($_POST['style']) ? $_POST['style'] : null;

	if($name && $style){
		$result = self::addBeer($name, $style);
		if($result){
			$message = "Successfully added \"$name\"";
		} else {
			$message = "Error: Unable to add beer with name \"$name\"";
		}
	} else {
		$message = "Must include both name and styleId";
	}

	echo json_encode(["message" => $message]);

    }

    public function actionIndex()
    {
        $beers = Beer::model()->findAll();

        $this->render('index', compact('beers'));
    }

    public static function addBeer($name, $style)
    {
	$result = false;

	$beer = new Beer();
	$beer->name = $name;
	$beer->styleId = $style;
	
	//Temp fix until database can be updated to have auto_increment id
	$beer->beerId = substr(md5(rand()), 0, 7);
	try {
		$result = $beer->save();
		$result = true;
	} catch (Exception $e) {
	}
	return $result;

    }

    public static function searchBeers($name, $style, $hop, $yeast, $malt, $lastBeerId)
    {
	$ids = (new Beer())->searchBeerIds($name, $style, $hop, $yeast, $malt, $lastBeerId);
	$beer_ids = [];
	foreach($ids as $id){
		$beer_ids[] = $id['beerId'];
	}
	$results = (new Beer())->searchBeersByIds($beer_ids);
	$beers = self::formatBeersSearchResult($results);
	return $beers;
    }

    private static function formatBeersSearchResult($result)
    {
	$finalResult = [];
	foreach($result as $r){
		$beerId = $r['beerId'];
		$entryToUpdate = isset($finalResult[$beerId]) ? $finalResult[$beerId] : [];

		$entryToUpdate['name'] = $r['beername'];
		$entryToUpdate['style'] = $r['stylename'];
		$entryToUpdate['beerId'] = $beerId;

		//Hops
		if(!isset($entryToUpdate['hops'])){
			$entryToUpdate['hops'] = [];
		}
		if($r['hopname']){
			$entryToUpdate['hops'][] = $r['hopname'];
			$entryToUpdate['hops'] = array_unique($entryToUpdate['hops']);
		}

		//Yeasts
		if(!isset($entryToUpdate['yeasts'])){
			$entryToUpdate['yeasts'] = [];
		}
		if($r['yeastname']){
			$entryToUpdate['yeasts'][] = $r['yeastname'];
			$entryToUpdate['yeasts'] = array_unique($entryToUpdate['yeasts']);
		}

		//Malts
		if(!isset($entryToUpdate['malts'])){
			$entryToUpdate['malts'] = [];
		}
		if($r['maltname']){
			$entryToUpdate['malts'][] = $r['maltname'];
			$entryToUpdate['malts'] = array_unique($entryToUpdate['malts']);
		}

		$finalResult[$beerId] = $entryToUpdate;	
	}

	return $finalResult;
    }
}
