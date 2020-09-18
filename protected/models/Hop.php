<?php

class Hop extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations() {
		return [
			'brewingUsage' => array(self::BELONGS_TO, 'LookupBrewingUsage', 'BrewingUsage'),
		];
	}
}