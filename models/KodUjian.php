<?php
namespace app\models;

class KodUjian extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'kod_ujian';
    }
    
    // return array [key => val, ...]
    static function dd($kat) {
        $data = self::find()->where(['kat_ujian' => $kat])->all();
        return \yii\helpers\ArrayHelper::map($data, 'id', 'kod_ujian');
    }
}