<?php
namespace app\controllers;

class PendaftaranController extends \yii\web\Controller {
    // display form pendaftaran
    function actionForm() {
        return $this->render('form');
    }
}