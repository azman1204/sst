<?php
namespace app\models;

class Pendaftaran extends \yii\db\ActiveRecord {
    // jika nama model dan nama table SAMA, tak perlu buat function tableName()
    function rules() {
        return [
            [['nama','nokp', 'jantina', 'alamat', 'tel', 'tkh_lahir'], 'required', 'message' => '{attribute} wajib diisi'],
            [['nokp'], 'string', 'length' => 12],
            [['nokp'], 'integer'],
            [['nokp'], 'unique'],
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