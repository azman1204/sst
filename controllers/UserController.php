<?php
namespace app\controllers;
use app\models\User;

class UserController extends \yii\web\Controller {
    function actionAccount() {
        return $this->render('account');
    }
    
    function actionPassword() {
        $err = [];
        $pwd = $_POST['pwd_old'];
        $pwd_new = $_POST['pwd_new'];
        $pwd_confirm = $_POST['pwd_confirm'];
        $user = User::find()->where(['user_id' => \Yii::$app->user->identity->user_id, 'pwd' => sha1($pwd)])->one();
        if (! $user) {
            $err[] = ['Katalaluan Asal Salah'];
        }
        
        if ($pwd_new !== $pwd_confirm) {
            $err[] = ['Katalaluan Baru dan Pengesahan Katalaluan Tidak Sama'];
        }

        $ok = false;
        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/',$pwd_new)) {
            $ok = true;
        }
        
        if (! $ok) {
            $err[] = ['Katalaluan haruslah mempunyai 8 karakter yang terdiri dari kombinasi huruf, nombor dan karakter spesial'];
        }
       
        
        if (count($err) == 0) {
            $msg[] = ['Katalaluan telah berjaya dikemaskini'];
            $data['msg'] = $msg;
            $user->pwd = sha1($pwd_new);
            $user->save();
        } else {
            $data['err'] = $err;
        }
        return $this->render('account', $data);
    }
    
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
        $user->pwd = 'xxxxxxxx';
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
        
        if($_POST['pwd'] !== 'xxxxxxxx' && $_POST['pwd'] !== '') {
            $user->pwd = sha1($_POST['pwd']);
        }
        
        $user->user_id = $_POST['user_id'];
        $level = $_POST['level'];
        $user->level = $level;

        if ($level == 'KLINIK') {
            $user->id_klinik = $_POST['id_klinik'];
        } else if ($level == 'PKD') {
            $user->id_pkd = $_POST['id_pkd'];
        }
        
        if($user->save()) {
            return $this->redirect('index.php?r=user/list');
        } else {
            $user->pwd = $_POST['pwd'];
            $err = $user->errors; // return array of errors
            return $this->render('form', ['user' => $user, 'err' => $err]);
        }
        
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