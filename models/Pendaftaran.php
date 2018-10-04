<?php
namespace app\models;

class Pendaftaran extends \yii\db\ActiveRecord {
    // jika nama model dan nama table SAMA, tak perlu buat function tableName()
    function rules() {
        $arr = [
            [['nama','nokp', 'jantina', 'alamat', 'tel', 'tkh_lahir'], 'required', 'message' => '{attribute} wajib diisi'],
            [['nokp'], 'string', 'length' => 12],
            [['nokp'], 'integer'],
            [['nokp'], 'unique'],
        ];
        if ($this->kes_indeks === 'Y') {
            $arr[] = [['nama_indeks', 'nokp_indeks'], 'required'];
        }
        return $arr;
    }
    
    public function attributeLabels()
    {
        return [
            'nokp' => 'No Kad Pengenalan',
            'nama' => 'Nama',
        ];
    }
}