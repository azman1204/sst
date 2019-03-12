<?php
namespace app\controllers;
use app\models\UjianSaringan;
use app\models\UjianPengesahan;
use app\models\KodUjian;

class DiagnosaAkhirController extends \yii\web\Controller {
    public function actionForm() {
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $diag1 = UjianPengesahan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        $diag2 = UjianSaringan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        if (! $diag1) {
            $diag1 = new UjianPengesahan();
        }
        $dat = KodUjian::findOne($diag1->kod_hbkeputusan);
        $catatan = $diag2->catatan2;
        if ($dat) {
            $diagnosa = $dat->diag_akhir;
        } else {
            $diagnosa = '';
        }
        return $this->render('form', ['diagnosa' => $diagnosa, 'catatan' => $catatan]);
    }
    
    public function actionSave() {
        $catatan = $_POST['catatan'];
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        //echo $id_pendaftaran;exit;
        $diag1 = UjianPengesahan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        $diag2 = UjianSaringan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        $diag2->catatan2 = $catatan;
        $diag2->save();
        if (! $diag1) {
            $diag1 = new UjianPengesahan();
        }
        $dat = KodUjian::findOne($diag1->kod_hbkeputusan);
        $catatan = $diag2->catatan2;
        
        if ($dat) {
            $diagnosa = $dat->diag_akhir;
        } else {
            $diagnosa = '';
        }
        return $this->render('form', [
            'msg' => 'Rekod telah disimpan', 
            'diagnosa' => $diagnosa,
            'catatan' => $catatan]);
    }
}