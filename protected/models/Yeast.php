<?php

class Yeast extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function findWithYeastId($yeastId) {
		return $this->find('yeastId = :yeastId', [':yeastId' => $yeastId]);
	}

	public function relations()
	{
		return [
			'beers' => array(self::MANY_MANY, 'Beer', 'beer_yeast(yeastId, beerId)'),
		];
	}
}
