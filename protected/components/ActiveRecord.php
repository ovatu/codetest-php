<?php

class ActiveRecord extends CActiveRecord
{
    public function tableName()
    {
        return lcfirst(parent::tableName());
    }
}
