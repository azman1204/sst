<?php
namespace app\controllers;
use app\models\UjianSaringan;
use app\models\UjianPengesahan;
use app\models\KodUjian;

class DiagnosaAkhirController extends \yii\web\Controller {
    public function actionForm() {
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $diag2 = UjianSaringan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        if (! $diag2) {
            $diag2 = new UjianSaringan();
        }
        $catatan = $diag2->catatan2;
        if ($diag2->id_diag_sementara == 1) {
            // normal - semasa ujian saringan
            $diagnosa = 'NORMAL';
        } else {
            $diag1 = UjianPengesahan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        
            if (! $diag1) {
                $diag1 = new UjianPengesahan();
            }
            $dat = KodUjian::findOne($diag1->kod_hbkeputusan);
            
            if ($dat) {
                $diagnosa = $dat->diag_akhir;
            } else {
                $diagnosa = '';
            }
        }
        return $this->render('form', ['diagnosa' => $diagnosa, 'catatan' => $catatan]);
    }
    
    public function actionSave() {
        $catatan = $_POST['catatan'];
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        //echo $id_pendaftaran;exit;
        $diag1 = UjianPengesahan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        $diag2 = UjianSaringan::find()->where(['id_pendaftaran' => $id_pendaftaran])->one();
        if (! $diag2) {
            $diag2 = new UjianSaringan();
            $diag2->id_pendaftaran = $id_pendaftaran;
        }
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