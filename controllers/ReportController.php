<?php
namespace app\controllers;
use kartik\mpdf\Pdf;

class ReportController extends \yii\web\Controller {
    function actionReten() {
        $request = \Yii::$app->request;
        $arr['sekolah'] = $request->post('sekolah');
        $arr['pkd'] = $request->post('pkd');

        $tahun_dari = $request->post('tahun_dari', '2019');
        $bulan_dari = $request->post('bulan_dari', '01');
        $arr['ym_dari'] = $tahun_dari . '-' . $bulan_dari . '-01';
        $arr['tahun_dari'] = $tahun_dari;
        $arr['bulan_dari'] = $bulan_dari;

        $tahun_hingga = $request->post('tahun_hingga', '2019');
        $bulan_hingga = $request->post('bulan_hingga', '12');
        $arr['ym_hingga'] = $tahun_hingga . '-' . $bulan_hingga . '-31';
        $arr['tahun_hingga'] = $tahun_hingga;
        $arr['bulan_hingga'] = $bulan_hingga;

        $arr['pks'] = $request->post('pks');
        $user = \Yii::$app->user->identity;
        $usr_level = $user->level;
        $arr['user'] = $user;

        if ($usr_level == 'KLINIK') {
            $id_klinik = $user->id_klinik;
            $arr['pks'] = $id_klinik;
            $sekolah_list = \app\mylib\Util::sekolah_klinik('sekolah', $id_klinik, $arr['sekolah']);
        } else if ($usr_level == 'PKD') {
            $id_pkd = $user->id_pkd;
            $pks_list = \app\mylib\Util::pks_list('pks', $id_pkd, $arr['pks']);
            $sekolah_list = \app\mylib\Util::sekolah_pkd('sekolah', $id_pkd, $arr['sekolah']);
            $arr['pks_list'] = $pks_list;
        } else {
            // hq
            $sekolah_list = \app\mylib\Util::sekolah_pkd('sekolah', $arr['pkd'], $arr['sekolah']);
            $pks_list = \app\mylib\Util::pks_list('pks', $arr['pkd'], $arr['pks']);
            $arr['pks_list'] = $pks_list;
        }

        \Yii::$app->session['arr'] = $arr; // set into session
        $arr['sekolah_list'] = $sekolah_list;
        $arr['usr_level'] = $usr_level;
        $result = $this->renderPartial('result', $arr);
        $arr['result'] = $result;
        $util = \app\models\Util::find()->where(['user_id' => \Yii::$app->user->identity->user_id])->one();
        if (!$util) {
            $util = new \app\models\Util();
        }
        $util->user_id = \Yii::$app->user->identity->user_id;
        $util->report = $result;
        $util->save();
        return $this->render('reten', $arr);
    }

    function actionCetak() {
        $arr = $this->getData();
        //\var_dump($arr);
        $util = \app\models\Util::find()->where(['user_id' => \Yii::$app->user->identity->user_id])->one();
        $arr['result'] = $util->report;
        return $this->renderPartial('cetak', $arr);
    }

    // search data base on previous post
    private function getData() {
        $arr = \Yii::$app->session->get('arr');
        if(isset($arr['pkd']) && $arr['pkd'] !== '0'){
            $pkd = \app\models\Rujukan::find()->where(['kod' => $arr['pkd'], 'kat' => 'pkd'])->one();
        } else {
            $pkd = new \app\models\Rujukan();
        }

        if(isset($arr['pks']) && $arr['pks'] !== '0'){
            $klinik = \app\models\Klinik::find()->where(['id' => $arr['pks']])->one();
        } else {
            $klinik = new \app\models\Klinik();
        }

        if(isset($arr['sekolah']) && $arr['sekolah'] !== '0'){
            $sekolah = \app\models\Sekolah::find()->where(['id' => $arr['sekolah']])->one();
        } else {
            $sekolah = new \app\models\Sekolah();
        }
        //\var_dump($arr);exit;
        return ['pkd' => $pkd, 'klinik' => $klinik, 'sekolah' => $sekolah, 'ym_dari' => $arr['ym_dari'], 'ym_hingga' => $arr['ym_hingga']];
    }

    function actionExcel() {
        $arr = $this->getData();
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=reten.xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        $util = \app\models\Util::find()->where(['user_id' => \Yii::$app->user->identity->user_id])->one();
        $arr['result'] = $util->report;
        //\var_dump($arr);
        return $this->renderPartial('cetak', $arr);
    }

    function actionPdf() {
        $util = \app\models\Util::find()->where(['user_id' => \Yii::$app->user->identity->user_id])->one();
        $content = $this->renderPartial('pdf', ['result' => $util->report]);
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '
                #my-table {
                    border: 1px solid #999;
                    width:100%;
                    font-size:11px;
                }

                #my-table td {
                    border: 1px solid #ddd;
                }

                .my-tr {
                    text-align:center;
                    background-color: #eee;
                    font-weight: 700;
                    color: #000;
                }

                .r1 {
                    background-color: white;
                }

                .r2 {
                    background-color: #ffffcc;
                }

                .total {
                    background-color: yellow;
                    font-weight: bold;
                }

                .tiada-rekod {
                    font-size: 14px;
                    color:red;
                }
            ',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            /*'methods' => [
                'SetHeader' => ['Krajee Report Header'],
                'SetFooter' => ['{PAGENO}'],
            ]*/
        ]);
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    function actionSekolah($pks) {
        echo \app\mylib\Util::sekolah_klinik('sekolah', $pks, '');
    }

    function actionPks($pkd) {
        echo \app\mylib\Util::pks_list('pks', $pkd, '');
    }

}
