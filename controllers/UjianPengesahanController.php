<?php
namespace app\controllers;
use app\models\UjianPengesahan;
use app\models\KodUjian;

class UjianPengesahanController extends \yii\web\Controller {
    function actionForm() {
        $data['dat'] = new UjianPengesahan();
        return $this->render('form', $data);
    }
    
    // index.php?r=ujian-pengesahan/kodujian
    function actionKodujian($id) {
        $dat = KodUjian::findOne($id);
        return $this->asJson($dat);
    }
}