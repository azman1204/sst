<?php
namespace app\models;

class KodUjian extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'kod_ujian';
    }
    
    // return array [key => val, ...]
    static function dd($kat, $opt='N') {
        $data = self::find()->where(['kat_ujian' => $kat])->all();
        $arr =  \yii\helpers\ArrayHelper::map($data, 'id', 'kod_ujian');
        if ($opt === 'Y') {
            $arr = ['0' => '--Sila Pilih--'] + $arr;
        }
        return $arr;
    }
}