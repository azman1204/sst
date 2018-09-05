<?php
namespace app\controllers;
use app\models\Pendaftaran; // import

class PendaftaranController extends \yii\web\Controller {
    // display form pendaftaran
    function actionForm() {
        return $this->render('form');
    }
    
    // insert data ke table pendaftaran
    function actionSave() {
        $p = new Pendaftaran();
        $p->nama = $_POST['nama'];
        $p->nokp = $_POST['nokp'];
        $p->save();
    }
    
    // list data dlm table
    function actionList() {
        $data = Pendaftaran::find()->all();
        // => double arrow array
        // -> single arrow obj
        $arr = ['dat' => $data];
        return $this->render('list', $arr);
    }
    
    
}