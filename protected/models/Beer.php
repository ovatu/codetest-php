<?php

const NO_BEER_FOUND = 'no beer found';
const PAGE_OUT_OF_RANGE = 'page out of range';
const PAGESIZE_DEFAULT = 10;
const PAGE_DEFAULT = 1;

class Beer extends ActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function findWithBeerId($beerId)
    {
        return $this->find('beerId = :beerId', [':beerId' => $beerId]);
	}

	public function relations()
	{
		return [
			'hops' => array(self::MANY_MANY, 'Hop', 'beer_hop(beerId, hopId)'),
			'beerHops' => array(self::HAS_MANY, 'BeerHop', 'beerId'),
			'style' => array(self::BELONGS_TO, 'Style', 'styleId'),
			'yeasts' => array(self::MANY_MANY, 'Yeast', 'beer_yeast(beerId, yeastId)'),
			'beerYeasts' => array(self::HAS_MANY, 'BeerYeast', 'beerId'),
			'malts' => array(self::MANY_MANY, 'Malt', 'beer_malt(beerId, maltId)'),
			'beerMalts' => array(self::HAS_MANY, 'BeerMalt', 'beerId'),
		];
	}

	public function hasHop($hop)
	{
		foreach ($this->beerHops as $beerHop) {
			if ($beerHop->hopId === $hop->hopId) return $beerHop;
		}

		return false;
	}

	public function addHop($hop)
	{
		$beerHop = $this->hasHop($hop);

		if (!$beerHop) {
			$beerHop = new BeerHop();
			$beerHop->beerId = $this->beerId;
			$beerHop->hopId = $hop->hopId;
			$beerHop->save();
		}

		return $beerHop;
	}

	public function removeHop($hop) {
		$beerHop = $this->hasHop($hop);

		if ($beerHop) {
			$beerHop->delete();
		}
	}

	public function hasYeast($yeast)
	{
		foreach ($this->beerYeasts as $beerYeast) {
			if ($beerYeast->yeastId === $yeast->yeastId) return $beerYeast;
		}

		return false;
	}

	public function addYeast($yeast)
	{
		$beerYeast = $this->hasYeast($yeast);

		if (!$beerYeast) {
			$beerYeast = new BeerYeast();
			$beerYeast->beerId = $this->beerId;
			$beerYeast->yeastId = $yeast->yeastId;
			$beerYeast->save();
		}

		return $beerYeast;
	}

	public function removeYeast($yeast) {
		$beerYeast = $this->hasYeast($yeast);

		if ($beerYeast) {
			$beerYeast->delete();
		}
	}

	public function hasMalt($malt)
	{
		foreach ($this->beerMalts as $beerMalt) {
			if ($beerMalt->maltId === $malt->maltId) return $beerMalt;
		}

		return false;
	}

	public function addMalt($malt)
	{
		$beerMalt = $this->hasMalt($malt);

		if (!$beerMalt) {
			$beerMalt = new BeerMalt();
			$beerMalt->beerId = $this->beerId;
			$beerMalt->maltId = $malt->maltId;
			$beerMalt->save();
		}

		return $beerMalt;
	}

	public function removeMalt($malt) {
		$beerMalt = $this->hasMalt($malt);

		if ($beerMalt) {
			$beerMalt->delete();
		}
	}

    /** Find all beers or use a search query to find based on beer name.
     * The results are chunked based on $pagesize.
     * We can return one specific page with the $page param.
     *
     * @param string $query a beer name to search for.
     * @param int    $pagesize the number of results to include in one page.
     * @param int    $page the specific page we want to return.
     * @return array|string an array of beers or string if we get an error.
     */
    public function findBeersByName($query = '', $pagesize = PAGESIZE_DEFAULT, $page = PAGE_DEFAULT)
    {
        if ($query) {
            // Case insensitive search.
            $c = new CDbCriteria();
            $c->addSearchCondition($this->getTableAlias() . '.name', $query);
            // TODO search the names and descriptions of the hops, malts, yeasts too.
            $beers = $this->findAll($c);
        } else {
            $beers = Beer::findAll();
        }
        if (empty($beers)) {
            return NO_BEER_FOUND;
        }
        $processedbeers = [];
        foreach ($beers as $beer) {
            $hops = $beer->hops;
            $yeast = $beer->yeasts;
            $malt = $beer->malts;
            $attributes = $beer->getAttributes();
            $processedbeers[] = compact('attributes', 'hops', 'yeast', 'malt');
        }
        // Do some pagination for when we have a lot of results.
        return Pagination::paginate($processedbeers, $pagesize, $page);
    }

    public function rules()
    {
        return array(
            // name is required
            array('name', 'required'),
            // Must be numeric.
            array('styleId,abv,ibu,isOrganic,year', 'numeric'),
            // Must be 6 characters
            array('beerId', 'primarykeylength'),
        );
    }

    function primarykeylength($attribute) {
        $keyattribute = $this->$attribute;
        if (isset($keyattribute) && is_string($keyattribute) && strlen($keyattribute) !== 6) {
            $this->addError($attribute, 'Must be six characters long!');
        }
    }
    function numeric($attribute) {
        $numericattribute = $this->$attribute;
        if (isset($numericattribute) && !is_numeric($numericattribute)) {
            $this->addError($attribute, 'Must be a numerical attribute!');
        }
    }

}

class BeerHop extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'beer_hop';
	}

	public function relations()
	{
		return [
			'beer' => array(self::BELONGS_TO, 'Beer', 'beerId'),
			'hop' => array(self::BELONGS_TO, 'Hop', 'hopId'),
		];
	}
}

class BeerYeast extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'beer_yeast';
	}

	public function relations()
	{
		return [
			'beer' => array(self::BELONGS_TO, 'Beer', 'beerId'),
			'yeast' => array(self::BELONGS_TO, 'Yeast', 'yeastId'),
		];
	}
}

class BeerMalt extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'beer_malt';
	}

	public function relations()
	{
		return [
			'beer' => array(self::BELONGS_TO, 'Beer', 'beerId'),
			'malt' => array(self::BELONGS_TO, 'Malt', 'maltId'),
		];
	}
}
