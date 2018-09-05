<?php
namespace app\controllers;

class HelloController extends \yii\web\Controller {
    // http://localhost/sst/web/index.php?r=hello/world
    // r = route
    // hello = HelloController
    //world = nama function actionWorld()
    function actionWorld() {
        echo "Hello World";
    }
    
    // http://localhost/sst/web/index.php?r=hello/yii
    function actionYii() {
        //echo "Hello Xian Xue";
        // panggil view
        // passing data ke view, guna array
        $arr = ['nama' => 'azman', 'alamat' => 'Puchong'];
        return $this->render('myhello', $arr); // view/hello/myhello.php
    }
    
    // http://localhost/sst/web/index.php?r=hello/list
    function actionList() {
        // panggil model
        // return semua data dlm table dlm bentuk array of obj (1 rekod dlm table)
        $data = \app\models\Pengguna::find()->all();
        //display data
        $arr = ['dat' => $data];
        return $this->render('senarai', $arr);
    }
}
