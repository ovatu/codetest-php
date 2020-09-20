<?php

class Hop extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function findWithHopId($hopId) {
		return $this->find('hopId = :hopId', [':hopId' => $hopId]);
	}

	public function relations()
	{
		return [
			'beers' => array(self::MANY_MANY, 'Beer', 'beer_hop(hopId, beerId)'),
		];
	}
}
