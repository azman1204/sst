<?php
namespace app\controllers;

class KaunselingController extends \yii\web\Controller {
    function actionForm() {
        return $this->render('form');
    }
}