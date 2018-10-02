<?php
namespace app\models;

class Kaunseling extends \yii\db\ActiveRecord {
    function rules() {
        $arr = [];
        if ($this->telah_kaunseling === 'Y') {
            $arr[] = ['tkh_kaunseling', 'required'];
        }
        return $arr;
    }
}