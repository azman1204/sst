<?php
namespace app\controllers;

class HomeController extends \yii\web\Controller {
    function actionIndex() {
        return $this->render('home');
    }
}