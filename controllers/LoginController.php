<?php
namespace app\controllers;

class LoginController extends \yii\web\Controller {
    // show login form
    function actionIndex() {
        return $this->renderPartial('form');
    }
    
    // authenticated submitted login form
    function actionAuth() {
        
    }
    
    // logout
    function actionLogout() {
        
    }
}