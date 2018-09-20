<?php
namespace app\models;

class Rujukan extends \yii\db\ActiveRecord {
    // drop down. return data sesuai utk display dd
    static function dd($kat) {
        $data = self::find()->where(['kat' => $kat])->all();
        return \yii\helpers\ArrayHelper::map($data, 'kod', 'keterangan');
    }
}