<?php

namespace app\controllers;

use app\models\Pendaftaran; // import / load
use yii\helpers\ArrayHelper;
use app\models\Sekolah;
use app\models\KumpEtnik;
use app\models\PecahanEtnik;

class PendaftaranController extends \yii\web\Controller {

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

    // on klik pada butang baru
    function actionForm() {
        $arr = $this->data();
        $p = new Pendaftaran();
        $p->kebenaran = 'Y'; // set default value
        $arr['dat'] = $p;
        $arr['new'] = 'Y';
        return $this->render('form', $arr);
    }

    // on klik pd tab pendaftaran
    function actionEdit2() {
        $id_pendaftaran = \Yii::$app->session->get('id_pendaftaran');
        $arr = $this->data();
        $arr['dat'] = Pendaftaran::findOne($id_pendaftaran);
        return $this->render('form', $arr);
    }

    // shared data
    private function data() {
        $user = \Yii::$app->user->identity;
        $sek = Sekolah::find()->where(['id_klinik' => $user->id_klinik])->all();
        $arr['sek'] = ArrayHelper::map($sek, 'id', 'nama');
        $etnik = KumpEtnik::find()->all();
        $arr['kump_etnik'] = ['0' => '--Sila Pilih--'] + ArrayHelper::map($etnik, 'id', 'nama');
        // maklumat klinik user yg logged-in
        $arr['klinik'] = \app\models\Klinik::findOne($user->id_klinik);
        return $arr;
    }

    // insert data ke table pendaftaran
    function actionSave() {
        $id = $_POST['id'];
        $arr = $this->data();
        if (empty($id)) {
            // insert / new data
            $p = new Pendaftaran();
            $arr['new'] = 'Y';
        } else {
            // update
            $p = Pendaftaran::findOne($id); // return a record obj
        }
        $p->nama = $_POST['nama'];
        $p->nokp = $_POST['nokp'];
        $p->tel = $_POST['tel'];
        $p->kebenaran = $_POST['kebenaran'];
        $p->alamat = $_POST['alamat'];
        $p->kump_etnik = $_POST['kump_etnik'];
        $p->umur = $_POST['umur'];
        
        if (isset($_POST['kes_indeks'])) {
            $p->kes_indeks = 'Y';
            $p->nama_indeks = $_POST['nama_indeks'];
            $p->nokp_indeks = $_POST['nokp_indeks'];
        }

        if (isset($_POST['pecahan_etnik'])) {
            $p->pecahan_etnik = $_POST['pecahan_etnik'];
        }

        if (isset($_POST['jantina'])) {
            $p->jantina = $_POST['jantina'];
        } else {
            // tak check mana2 pilihan jantina
            $p->jantina = '';
        }

        $p->tkh_lahir  = $_POST['tkh_lahir'];
        $p->id_sekolah = $_POST['id_sekolah'];
        $p->id_klinik  = \Yii::$app->user->identity->id_klinik; // patut baca dari session user yg login
        // validation
        if ($p->validate()) {
            // validation ok. then baru save data
            $p->save();
            return $this->redirect('index.php?r=pendaftaran/list');
        } else {
            // validation ko
            // show err msg, show ori form
            $err = $p->errors; // return array of errors
            $arr['dat'] = $p;
            $arr['salah'] = $err;
            return $this->render('form', $arr);
        }
    }

    // called by AJAX
    function actionPecahan($id, $id_pecahan) {
        $pecahan = PecahanEtnik::find()->where(['id_etnik' => $id])->all();
        $pecahan_etnik = ArrayHelper::map($pecahan, 'id', 'nama_pecahan');
        echo \yii\helpers\Html::dropDownList('pecahan_etnik', $id_pecahan, $pecahan_etnik, ['class' => 'form-control']);
        //echo "test...$id";
    }

    // list data dlm table
    function actionList() {
        $data = Pendaftaran::find()->where(['id_klinik' => \Yii::$app->user->identity->id_klinik])->all(); // return array of obj pendaftaran
        // => double arrow array
        // -> single arrow obj
        $arr = ['dat' => $data];
        return $this->render('list', $arr);
    }

    function actionDelete($id) {
        // delete from pendaftaran where id = 1
        Pendaftaran::deleteAll(['id' => $id]);
        // redirect ke list
        return $this->redirect('index.php?r=pendaftaran/list');
    }

    // show form with ori. data, reuse existing form 
    function actionEdit($id) {
        // retrieve / query data asal. 
        // select * from pendaftaran where id = 1
        \Yii::$app->session->set('id_pendaftaran', $id); // set session
        $data = Pendaftaran::findOne($id);
        $arr = $this->data();
        $arr['dat'] = $data;
        return $this->render('form', $arr);
    }

}
