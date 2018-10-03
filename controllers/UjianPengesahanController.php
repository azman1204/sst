<?php
namespace app\controllers;
use app\models\UjianPengesahan;
use app\models\KodUjian;

class UjianPengesahanController extends \yii\web\Controller {
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
    
    function actionForm() {
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $ujian = UjianPengesahan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        
        if (! $ujian) {
            // jika data belum wujud dlm table ujian_pengesahan
            $ujian = new UjianPengesahan();
        }
        $data['dat'] = $ujian;
        return $this->render('form', $data);
    }
    
    // index.php?r=ujian-pengesahan/kodujian
    function actionKodujian($id) {
        $dat = KodUjian::findOne($id);
        return $this->asJson($dat);
    }
    
    function actionSave() {
        $id = $_POST['id'];
        if (empty($id)) {
            // insert
            $ujian = new UjianPengesahan();
            $ujian->id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        } else {
            // update
            $ujian = UjianPengesahan::findOne($id);
        }
        
        $ujian->tkh_hbhantar = $_POST['tkh_hbhantar'];
        $ujian->tkh_hbkeputusan = $_POST['tkh_hbkeputusan'];
        $ujian->kod_hbkeputusan = $_POST['kod_hbkeputusan'];
        $ujian->tkh_dnahantar = $_POST['tkh_dnahantar'];
        $ujian->tkh_dnakeputusan = $_POST['tkh_dnakeputusan'];
        $ujian->kod_dnakeputusan = $_POST['kod_dnakeputusan'];
        
        if ($ujian->validate()) {
            $ujian->save();
            $this->redirect('index.php?r=pendaftaran/list');
        } else {
            $arr['salah'] = $ujian->getErrors();
            $arr['dat'] = $ujian;
            $this->render('form', $arr);
            
        }
    }
}