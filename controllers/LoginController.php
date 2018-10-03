<?php
namespace app\controllers;
use app\models\User;

class LoginController extends \yii\web\Controller {
    // show login form
    function actionIndex() {
        return $this->renderPartial('form');
    }
    
    // authenticated submitted login form
    function actionAuth() {
        $user = User::find()
                ->where(['user_id' => $_POST['user_id'], 'pwd' => $_POST['pwd']])
                ->one();
        if ($user) {
            // user exist
            \Yii::$app->user->login($user); // register user ke dlm session
            return $this->redirect('index.php?r=pendaftaran/list');
        } else {
            // user not exist
            \Yii::$app->session->setFlash('err', 'Kombinasi ID Pengguna dan Katalaluan Salah');
            return $this->redirect('index.php?r=login');
        }
    }
    
    // logout
    function actionLogout() {
        \Yii::$app->user->logout();
        return $this->redirect('index.php?r=login');
    }
}