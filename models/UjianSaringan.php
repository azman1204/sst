<?php
namespace app\models;

// nama table ujian_saringan MATCH dengan nama model UjianSaringan
class UjianSaringan extends \yii\db\ActiveRecord {
    // guna jika nama model tak match nama table
    public static function tableName() {
        return 'ujian_saringan';
    }
    
    public function rules() {
       return [
            [['hb','mch'], 'required', 'message' => '{attribute} wajib diisi'],
        ];
    }
    
    public function attributeLabels() {
        return [];
    }
}