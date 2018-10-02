<?php
namespace app\controllers;
use app\models\Kaunseling;

class KaunselingController extends \yii\web\Controller {
    function actionForm() {
        return $this->render('form');
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
        
        if (isset($_POST['telah_kaunseling'])) {
            $kaunseling->telah_kaunseling = $_POST['telah_kaunseling'];
        }
        
        $kaunseling->tkh_kaunseling = $_POST['tkh_kaunseling'];
        $kaunseling->catatan = $_POST['catatan'];
        $kaunseling->sebab_cicir = $_POST['sebab_cicir'];
        
        if ($kaunseling->validate()) {
            // validation ok. then baru save data
            $kaunseling->id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
            $kaunseling->save();
            return $this->redirect('index.php?r=pendaftaran/list');
        } else {
            // validation ko
            return $this->render('form', $arr);
        }
    }
}