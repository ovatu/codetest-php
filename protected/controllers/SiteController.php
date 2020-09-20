<?php

class SiteController extends CController
{
    public function actionIndex()
    {
        $beers = Beer::model()->findAll();

        $this->render('index', compact('beers'));
    }
}
