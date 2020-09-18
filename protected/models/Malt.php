<?php

class Malt extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations() {
		return [
			'maltster' => array(self::BELONGS_TO, 'LookupMaltster', 'Maltster'),
			'grain' => array(self::BELONGS_TO, 'LookupGrain', 'Grain'),
		];
	}
}