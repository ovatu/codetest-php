<?php

class Yeast extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations() {
		return [
			'lab' => array(self::BELONGS_TO, 'LookupLab', 'Lab'),
			'form' => array(self::BELONGS_TO, 'LookupYeastForm', 'Lab'),
			'flocculation' => array(self::BELONGS_TO, 'LookupYeastFlocculation', 'Flocculation'),
			'strain' => array(self::BELONGS_TO, 'LookupYeastStrain', 'Strain'),
		];
	}
}