<?php
namespace app\controllers;
use app\models\User;

class UserController extends \yii\web\Controller {
    // show login form
    function actionList() {
        $users = User::find()->all();
        return $this->render('list', ['users' => $users]);
    }
    
    function actionNew() {
        $user = new User();
        return $this->render('form', ['user' => $user]);
    }
    
    function actionDel($id) {
        $user = User::find()->where(['id' => $id])->one();
        $user->delete();
        return $this->redirect('index.php?r=user/list');
    }
    
    function actionEdit($id) {
        $user = User::find()->where(['id' => $id])->one();
        return $this->render('form', ['user' => $user]);
    }
    
    function actionSave() {
        $id = $_POST['id'];
        if (empty($id)) {
            // insert
            $user = new User();
        } else {
            // update
            $user = User::find()->where(['id' => $id])->one();
        }
        
        $user->name = $_POST['name'];
        $user->post = $_POST['post'];
        $user->pwd = $_POST['pwd'];
        $user->user_id = $_POST['user_id'];
        $level = $_POST['level'];
        $user->level = $level;
        if ($level == 'klinik') {
            $user->id_klinik = $_POST['id_klinik'];
        } else if ($level == 'pkd') {
            $user->id_pkd = $_POST['id_pkd'];
        }
        $user->save();
        return $this->redirect('index.php?r=user/list');
    }
    
    function actionKlinik($level) {
        $klinik = \app\models\Klinik::find()->all();
        $str = "<select name='id_klinik' class='form-control'>";
        foreach ($klinik as $k) {
            $s = $level == $k->id ? 'selected' : '';
            $str .= "<option value='$k->id' $s>$k->nama</option>";
        }
        $str .= "</select>";
        echo $str;
    }
    
    function actionPkd($level) {
        $ref = \app\models\Rujukan::find()->where(['kat' => 'pkd'])->all();
        $str = "<select name='id_pkd' class='form-control'>";
        foreach ($ref as $k) {
            $s = $level == $k->id ? 'selected' : '';
            $str .= "<option value='$k->kod' $s>$k->keterangan</option>";
        }
        $str .= "</select>";
        echo $str;
    }
}