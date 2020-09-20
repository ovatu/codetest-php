<?php

class Style extends ActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function findWithStyleId($styleId) {
		return $this->find('styleId = :styleId', [':styleId' => $styleId]);
	}

	public function relations()
	{
		return [
			'beers' => array(self::HAS_MANY, 'Beer', 'styleId'),
		];
	}
}
