<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['user_id', 'pwd', 'name', 'level'], 'required', 'message' => '{attribute} wajib diisi'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Nama',
            'user_id' => 'ID Pengguna',
            'pwd' => 'Katalaluan'    
        ];
    }

    // see Yii::$app->user->identity
    public static function findIdentity($id)
    {
        return self::find()->where(['user_id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

}
