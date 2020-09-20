<?php

class Malt extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function findWithMaltId($maltId) {
		return $this->find('maltId = :maltId', [':maltId' => $maltId]);
	}

	public function relations()
	{
		return [
			'beers' => array(self::MANY_MANY, 'Beer', 'beer_malt(maltId, beerId)'),
		];
	}
}
