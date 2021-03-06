<?php

namespace app\controllers;
use yii\data\Pagination;
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
        $dat = Pendaftaran::findOne($id_pendaftaran);
        $arr = $this->data($dat->id_klinik);
        $arr['dat'] = $dat;
        $arr['klinik'] = \app\models\Klinik::findOne($dat->id_klinik);
        return $this->render('form', $arr);
    }

    // shared data
    private function data($id_klinik = 0) {
        $user = \Yii::$app->user->identity;
        if ($id_klinik == 0) {
            $sek = Sekolah::find()->where(['id_klinik' => $user->id_klinik])->all();
        } else {
            $sek = Sekolah::find()->where(['id_klinik' => $id_klinik])->all();
        }
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
            $p->created_by = \Yii::$app->user->identity->id;
        } else {
            // update
            $p = Pendaftaran::findOne($id); // return a record obj
            $p->updated_by = \Yii::$app->user->identity->id;
            $p->updated_dt = date('Y-m-d H:i:s');
        }
        $p->nama = $_POST['nama'];
        $p->nokp = $_POST['nokp'];
        $p->tel = $_POST['tel'];
        $p->kebenaran = $_POST['kebenaran'];
        $p->alamat = $_POST['alamat'];
        $p->kump_etnik = $_POST['kump_etnik'];
        $p->umur = $_POST['umur'];
        //$p->tahun_reten = $_POST['tahun_reten'];
        
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
        
        if (\Yii::$app->user->identity->level === 'KLINIK') {
            $p->id_klinik  = \Yii::$app->user->identity->id_klinik; // patut baca dari session user yg login
        }
        
        // validation
        if ($p->validate()) {
            // validation ok. then baru save data
            $p->save();

            $k = new \app\models\Kaunseling();
            $k->id_pendaftaran = $p->id;
            $k->telah_kaunseling = 'T';
            $k->save();

            return $this->redirect('index.php?r=pendaftaran/list&list=y');
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
    
    // called by AJAX
    function actionKlinik($pkd, $s = '') {
        $klinik = \app\models\Klinik::find()->where(['id_pkd' => $pkd])->all();
        $arr = [0 => '--sila pilih--'] + ArrayHelper::map($klinik, 'id', 'nama');
        echo \yii\helpers\Html::dropDownList('klinik', $s, $arr, ['class' => 'form-control']);
    }
    
    // called by AJAX
    function actionSekolah($klinik, $s='') {
        $sek = \app\models\Sekolah::find()->where(['id_klinik' => $klinik])->all();
        $arr = [0 => '--sila pilih--'] + ArrayHelper::map($sek, 'id', 'nama');
        echo \yii\helpers\Html::dropDownList('sekolah', $s, $arr, ['class' => 'form-control']);
    }

    // list data dlm table
    function actionList() {
        $arr['nokp'] = '';
        $arr['nama'] = '';
        $arr['pkd']  = '';
        $arr['klinik'] = '';
        $arr['sek'] = '';
        $arr['tkh_dari'] = '';
        $arr['tkh_hingga'] = '';
        $arr['id_diag_sementara'] = '0';
        $arr['status_ujian'] = 0;
        
        $user = \Yii::$app->user->identity;
        $level = $user->level;
        
        $q = Pendaftaran::find()->where([]);
        if ($level === 'KLINIK') {
            $q = $q->andWhere(['id_klinik' => $user->id_klinik]);
        } else if ($level === 'PKD') {
            $q->leftJoin('klinik', "pendaftaran.id_klinik = klinik.id");
            $q->andWhere(['id_pkd' => $user->id_pkd]);
        } else if ($level == 'HQ') {
            $q->leftJoin('klinik', "pendaftaran.id_klinik = klinik.id");
        }

        // on submit carian
        if (isset($_POST['nokp'])) {
            $nokp = $_POST['nokp'];
            if (! empty($nokp)) {
                $q->andWhere(['=', 'nokp', $nokp]);
            }
            
            $nama = $_POST['nama'];
            if (! empty($nama)) {
                $q->andWhere(['like', 'pendaftaran.nama', $nama]);
            }

            if ($level === 'pkd' || $level === 'hq') {
                $klinik = $_POST['klinik'];
                $arr['klinik'] = $klinik;
                if ($klinik !== '0') {
                    $q->andWhere(['=', 'id_klinik', $klinik]);
                }
            }
            
            if (isset($_POST['sekolah'])) {
                $sek = $_POST['sekolah'];
                $arr['sek'] = $sek;
                if ($sek !== '0') {
                    $q->andWhere(['=', 'id_sekolah', $sek]);
                }
            }
            
            // list semua data dibawah sesuatu PKD
            if ($level === 'hq') {
                $pkd = $_POST['pkd'];
                $arr['pkd'] = $pkd;
                if ($pkd !== '0' && $klinik === '0') {
                    $q->andWhere(['id_pkd' => $pkd]);
                }
            }
            
            // search by date from .. to
            $tkh_dari = $_POST['tkh_dari'];
            $tkh_hingga = $_POST['tkh_hingga'];
            $arr['tkh_dari'] = $tkh_dari;
            $arr['tkh_hingga'] = $tkh_hingga;
            if (!empty($tkh_dari) && !empty($tkh_hingga)) {
                $q->andWhere(['>=', 'created_dt', $tkh_dari . ' 00:00:00']);
                $q->andWhere(['<=', 'created_dt', $tkh_hingga . ' 23:59:59']);
            }
    
            // status ujian
            $status = '0';
            if ($_POST['status_ujian'] !== '0') {
                $status = $_POST['status_ujian'];
                $q->leftJoin('kaunseling', 'pendaftaran.id = kaunseling.id_pendaftaran');
                $q->andWhere(['=', 'kaunseling.telah_kaunseling', $status]);
            }
    
            // diagnosis sementara
            $id = '0';
            if ($_POST['id_diag_sementara'] !== '0') {
                $id = $_POST['id_diag_sementara'];
                $q->leftJoin('ujian_saringan', 'pendaftaran.id = ujian_saringan.id_pendaftaran');
                $q->andWhere(['=', 'ujian_saringan.id_diag_sementara', $id]);
            }

            $q->orderBy('nama');
            $ob = 'nama';

            $arr['nokp'] = $nokp;
            $arr['nama'] = $nama;
            $arr['status_ujian'] = $status;
            $arr['id_diag_sementara'] = $id;

            \Yii::$app->session['query'] = $q;
            \Yii::$app->session['arr'] = $arr;
        } else if (isset($_GET['page']) || isset($_GET['ob'])) {
            // click on pagination or order by
            $q = \Yii::$app->session['query'];
            $arr = \Yii::$app->session['arr'];
            if(isset($_GET['ob'])) {
                $q->orderBy($_GET['ob']);
                $ob = $_GET['ob'];
            }
        } else {
            // klik directly dari menu ke list or bila save pendaftaran
            if (! isset($_POST['nokp'])) {
                $q->andWhere(['like', 'created_dt', date('Y-m-d')]);
                $q->orderBy('nama');
                $ob = 'nama';
                $pagination = new Pagination(['totalCount' => $q->count()]);
                $pagination->pageSize = 5;
                $pagination->params = ['ob' => $ob];
                $data = $q->offset($pagination->offset)
                    ->limit($pagination->limit)->all();
                $arr['dat'] = $data;
                $arr['pagination'] = $pagination;
                return $this->render('list', $arr);
            }
        }

        //echo $q->createCommand()->getRawSql();
        
        $pagination = new Pagination(['totalCount' => $q->count()]);
        $pagination->pageSize = 5;
        $data = $q->offset($pagination->offset)->limit($pagination->limit)->all();
        $arr['dat'] = $data;
        $arr['pagination'] = $pagination;
        return $this->render('list', $arr);
    }

    function actionDelete($id) {
        // delete from pendaftaran where id = 1
        Pendaftaran::deleteAll(['id' => $id]);
        // redirect ke list
        \app\models\Kaunseling::deleteAll(['id_pendaftaran' => $id]);
        \app\models\UjianPengesahan::deleteAll(['id_pendaftaran' => $id]);
        \app\models\UjianSaringan::deleteAll(['id_pendaftaran' => $id]);
        return $this->redirect('index.php?r=pendaftaran/list');
    }

    // show form with ori. data, reuse existing form 
    function actionEdit($id) {
        // retrieve / query data asal. 
        // select * from pendaftaran where id = 1
        \Yii::$app->session->set('id_pendaftaran', $id); // set session
        $data = Pendaftaran::findOne($id);
        $arr = $this->data($data->id_klinik);
        $arr['dat'] = $data;
        $arr['klinik'] = \app\models\Klinik::findOne($data->id_klinik);
        return $this->render('form', $arr);
    }

}
