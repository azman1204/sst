<?php
namespace app\models;

class Pengguna extends \yii\db\ActiveRecord {
    static function tableName() {
        return 'user';
    }
}