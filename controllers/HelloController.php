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
        echo "Hello Xian Xue";
    }
}
