<?php

namespace app\controllers;

use kartik\mpdf\Pdf;

class ReportController extends \yii\web\Controller {

    function actionReten() {
        $request = \Yii::$app->request;
        $arr['sekolah'] = $request->post('sekolah');
        $arr['pkd'] = $request->post('pkd');
        $arr['tahun'] = $request->post('tahun');
        $arr['pks'] = $request->post('pks');
        \Yii::$app->session['arr'] = $arr;

        $user = \Yii::$app->user->identity;
        $usr_level = $user->level;

        if ($usr_level == 'klinik') {
            $id_klinik = $user->id_klinik;
            $sekolah_list = \app\mylib\Util::sekolah_klinik('sekolah', $id_klinik, $arr['sekolah']);
        } else if ($usr_level == 'pkd') {
            $id_pkd = $user->id_pkd;
            $pks_list = \app\mylib\Util::pks_list('pks', $id_pkd, $arr['pks']);
            $sekolah_list = \app\mylib\Util::sekolah_pkd('sekolah', $id_pkd, $arr['pks']);
            $arr['pks_list'] = $pks_list;
        } else {
            // hq
            $sekolah_list = \app\mylib\Util::sekolah_pkd('sekolah', $arr['pkd'], $arr['sekolah']);
            $pks_list = \app\mylib\Util::pks_list('pks', $arr['pkd'], $arr['pks']);
            $arr['pks_list'] = $pks_list;
        }
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
        $arr = \Yii::$app->session->get('arr');
        $pkd = \app\models\Rujukan::find()->where(['kod' => $arr['pkd'], 'kat' => 'pkd'])->one();
        $klinik = \app\models\Klinik::find($arr['pks'])->one();
        $sekolah = \app\models\Sekolah::find($arr['sekolah'])->one();
        //var_dump($klinik);exit;
        $util = \app\models\Util::find()->where(['user_id' => \Yii::$app->user->identity->user_id])->one();
        return $this->renderPartial('cetak', [
            'result' => $util->report, 'pkd' => $pkd, 'klinik'=>$klinik, 'sekolah'=>$sekolah, 'tahun' => $arr['tahun']]);
    }

    function actionExcel() {
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=reten.xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        $util = \app\models\Util::find()->where(['user_id' => \Yii::$app->user->identity->user_id])->one();
        return $this->renderPartial('cetak', ['result' => $util->report]);
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