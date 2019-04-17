<?php
namespace app\controllers;
use app\models\UjianSaringan;

class UjianSaringanController extends \yii\web\Controller {
    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (\Yii::$app->user->isGuest) {
            $this->redirect('index.php?r=login');
            return false;
        }
        return true;
    }
    
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
            $ujian->menjalani_ujian = 'Y'; // set default value
        }
        
        $arr = ['dat' => $ujian];
        return $this->render('form', $arr);
    }
    
    function actionSave() {
        $id = $_POST['id'];
        if (empty($id)) {
            // insert / new data
            $dat = new \app\models\UjianSaringan();
            $dat->created_by = \Yii::$app->user->identity->id;
        } else {
            // update
            $dat = \app\models\UjianSaringan::findOne($id); // return a record obj
            $dat->updated_by = \Yii::$app->user->identity->id;
            $dat->updated_dt = date('Y-m-d H:i:s');
        }
        
        $dat->id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $dat->hb = $_POST['hb'];
        $dat->mch = $_POST['mch'];
        $dat->mcv = $_POST['mcv'];
        $dat->mchc = $_POST['mchc'];
        $dat->rdw = $_POST['rdw'];
        $dat->rbc = $_POST['rbc'];
        $dat->tkh_ujian = $_POST['tkh_ujian'];
        $dat->id_diag_sementara = $_POST['id_diag_sementara'];
        $dat->menjalani_ujian = $_POST['menjalani_ujian'];
        $dat->catatan = $_POST['catatan'];
        
        // validation
        if ($dat->validate()) {
            // validation ok. then baru save data
            $dat->save();
            //return $this->redirect('index.php?r=pendaftaran/list');
            return $this->render('form', ['dat' => $dat, 'msg' => 'Rekod telah disimpan']);
        } else {
            // validation ko
            // show err msg, show ori form
            $err = $dat->errors; // return array of errors
            return $this->render('form', ['dat' => $dat, 'salah' => $err]);
        }
    }
}

