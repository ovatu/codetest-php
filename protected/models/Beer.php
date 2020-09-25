<?php

class Beer extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function findWithBeerId($beerId) {
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

	public function searchBeerIds($name, $style, $hop, $yeast, $malt, $lastBeerId = null)
	{
		$selectFields = ['b.beerId'];
		$limit = 10;

		$query = Yii::app()->db->createCommand()
			 ->selectDistinct($selectFields)
			 ->from('Beer b')
			 ->leftjoin('Style s', 'b.styleId=s.styleId')
			 ->leftjoin('Beer_Hop b_h', 'b.beerId = b_h.beerId')
			 ->leftJoin('Hop h', 'h.hopId = b_h.hopId')
			 ->leftjoin('Beer_Yeast b_y', 'b.beerId = b_y.beerId')
			 ->leftJoin('Yeast y', 'y.yeastId = b_y.yeastId')
			 ->leftjoin('Beer_Malt b_m', 'b.beerId = b_m.beerId')
			 ->leftJoin('Malt m', 'm.maltId = b_m.maltId')
			 ->order('b.beerId')
		 	 ->andWhere('b.beerId IS NOT NULL')
		 	 ->limit($limit);
		
		if($name){
			$query->andWhere('b.name=:name', [':name'=>$name]);
		}
		if($style){
			$query->andWhere('s.name=:style', [':style'=>$style]);
		}
		if($hop){
			$query->andWhere('h.name = :hop', [':hop' => $hop]);
		}
		if($yeast){
			$query->andWhere('y.name = :yeast', [':yeast' => $yeast]);
		}
		if($malt){
			$query->andWhere('m.name = :malt', [':malt' => $malt]);
		}
		if($lastBeerId){
			$query->andWhere("b.beerId > '$lastBeerId'");
		}

		$result = $query->query();
		return $result;

	}

	public function searchBeersByIds($beer_ids)
	{
		$selectFields = ['b.beerId',
			'b.name as beername',
			'b.styleId',
			's.name as stylename',
			'h.hopId',
			'h.name as hopname',
			'y.yeastId',
			'y.name as yeastname',
			'm.maltId',
			'm.name as maltname'
		];

		$query = Yii::app()->db->createCommand()
			  ->select($selectFields)
			  ->from('Beer b')
			  ->leftjoin('Style s', 'b.styleId=s.styleId')
			  ->leftjoin('Beer_Hop b_h', 'b.beerId = b_h.beerId')
			  ->leftjoin('Beer_Yeast b_y', 'b.beerId = b_y.beerId')
			  ->leftjoin('Beer_Malt b_m', 'b.beerId = b_m.beerId')
			  ->leftJoin('Hop h', 'h.hopId = b_h.hopId')
			  ->leftJoin('Yeast y', 'y.yeastId = b_y.yeastId')
			  ->leftJoin('Malt m', 'm.maltId = b_m.maltId')
		  	  ->order('b.beerId')
		  	  ->andWhere(['in', 'b.beerId', $beer_ids]);
		
		
		$result = $query->query();
		return $result;
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
