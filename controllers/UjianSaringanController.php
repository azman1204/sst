<?php
namespace app\controllers;
use app\models\UjianSaringan;

class UjianSaringanController extends \yii\web\Controller {
    // show form to key-in ujian saringan result
    // ?index.php?r=ujian-saringan/form
    function actionForm() {
        // fikirkan .. dah ada data atau belum
        // folder views = ujian-saringan
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $ujian = UjianSaringan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        
        if (! $ujian) {
            // jika data belum wujud dlm table ujian_saringan
            $ujian = new UjianSaringan();
        }
        
        $arr = ['dat' => $ujian];
        return $this->render('form', $arr);
    }
    
    function actionSave() {
        $id = $_POST['id'];
        if (empty($id)) {
            // insert / new data
            $dat = new \app\models\UjianSaringan();
        } else {
            // update
            $dat = \app\models\UjianSaringan::findOne($id); // return a record obj
        }
        
        $dat->id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $dat->hb = $_POST['hb'];
        $dat->mch = $_POST['mch'];
        
        // validation
        if ($dat->validate()) {
            // validation ok. then baru save data
            $dat->save();
            return $this->redirect('index.php?r=pendaftaran/list');
        } else {
            // validation ko
            // show err msg, show ori form
            $err = $dat->errors; // return array of errors
            return $this->render('form', ['dat' => $dat, 'salah' => $err]);
        }
    }
}

