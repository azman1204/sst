<?php

namespace app\controllers;

use app\models\Kaunseling;

class KaunselingController extends \yii\web\Controller {

    function actionForm() {
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $kaunseling = Kaunseling::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        
        if (! $kaunseling) {
            // jika data belum wujud dlm table kaunseling
            $kaunseling = new Kaunseling();
            $kaunseling->telah_kaunseling = 'T';
        }
        
        return $this->render('form', ['dat' => $kaunseling]);
    }

    function actionSave() {
        $id = $_POST['id'];
        if (empty($id)) {
            // insert
            $kaunseling = new Kaunseling();
        } else {
            // updae
            $kaunseling = Kaunseling::findOne($id);
        }

        $kaunseling->telah_kaunseling = $_POST['telah_kaunseling'];

        if (isset($_POST['tkh_kaunseling'])) {
            $kaunseling->tkh_kaunseling = $_POST['tkh_kaunseling'];
        } else {
            $kaunseling->tkh_kaunseling = null;
        }
        
        $kaunseling->catatan = $_POST['catatan'];
        $kaunseling->sebab_cicir = $_POST['sebab_cicir'];

        if ($kaunseling->validate()) {
            // validation ok. then baru save data
            $kaunseling->id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
            $kaunseling->save();
            return $this->redirect('index.php?r=pendaftaran/list');
        } else {
            // validation ko
            $arr['dat'] = $kaunseling;
            $arr['salah'] = $kaunseling->getErrors();
            return $this->render('form', $arr);
        }
    }

}
