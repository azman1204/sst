<?php
namespace app\controllers;
use app\models\UjianPengesahan;

class UjianPengesahanController extends \yii\web\Controller {
    function actionForm() {
        $data['dat'] = new UjianPengesahan();
        return $this->render('form', $data);
    }
}