<?php
namespace app\models;

class Pendaftaran extends \yii\db\ActiveRecord {
    // jika nama model dan nama table SAMA, tak perlu buat function tableName()
    function rules() {
        return [
            [['nama','nokp'], 'required', 'message' => '{attribute} wajib diisi'],
            [['nokp'], 'string', 'length' => 12],
            [['nokp'], 'integer']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'nokp' => 'No Kad Pengenalan',
            'nama' => 'Nama',
        ];
    }
}