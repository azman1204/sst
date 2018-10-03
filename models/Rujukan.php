<?php
namespace app\models;

class Rujukan extends \yii\db\ActiveRecord {
    // drop down. return data sesuai utk display dd
    static function dd($kat, $opt = 'N') {
        $data = self::find()->where(['kat' => $kat])->all();
        $arr =  \yii\helpers\ArrayHelper::map($data, 'kod', 'keterangan');
        if ($opt === 'Y') {
            $arr = ['0' => '--Sila Pilih--'] + $arr;
        }
        return $arr;
    }
    
    static function getKeterangan($kat, $code) {
        $ruj = self::find()->where(['kat' => $kat, 'kod' =>$code])->one();
        if ($ruj) {
            return $ruj->keterangan;
        } else {
            return '';
        }
    }
}