<?php
namespace app\controllers;
use app\models\Pendaftaran; // import / load
use yii\helpers\ArrayHelper;
use app\models\Sekolah;
use app\models\KumpEtnik;
use app\models\PecahanEtnik;

class PendaftaranController extends \yii\web\Controller {
    // display form pendaftaran
    function actionForm() {
        $arr = $this->data();
        $arr['dat'] = new Pendaftaran();
        return $this->render('form', $arr);
    }
    
    function data() {
        $sek = Sekolah::find()->all();
        $arr['sek'] = ArrayHelper::map($sek, 'id', 'nama');
        $etnik = KumpEtnik::find()->all();
        $arr['kump_etnik'] = ArrayHelper::map($etnik, 'id', 'nama');
        return $arr;
    }
    
    // called by AJAX
    function actionPecahan($id) {
        $pecahan = PecahanEtnik::find()->where(['id_etnik' => $id])->all();
        $pecahan_etnik = ArrayHelper::map($pecahan, 'id', 'nama_pecahan');
        echo \yii\helpers\Html::dropDownList('pecahan_etnik', '', $pecahan_etnik, ['class'=>'form-control']);
        //echo "test...$id";
    }


    // insert data ke table pendaftaran
    function actionSave() {
        $id = $_POST['id'];
        if (empty($id)) {
            // insert / new data
            $p = new Pendaftaran();
        } else {
            // update
            $p = Pendaftaran::findOne($id); // return a record obj
        }
        $p->nama = $_POST['nama'];
        $p->nokp = $_POST['nokp'];
        
        // validation
        if ($p->validate()) {
            // validation ok. then baru save data
            $p->save();
            return $this->redirect('index.php?r=pendaftaran/list');
        } else {
            // validation ko
            // show err msg, show ori form
            $err = $p->errors; // return array of errors
            $arr = $this->data();
            $arr['dat'] = $p;
            $arr['salah'] = $err;
            return $this->render('form', $arr);
        }
    }
    
    // list data dlm table
    function actionList() {
        $data = Pendaftaran::find()->all();// return array of obj pendaftaran
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
        $arr = ['dat' => $data];
        return $this->render('form', $arr);
    }
}