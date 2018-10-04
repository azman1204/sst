<?php
$user = \Yii::$app->user->identity;
?>
<!doctype html>
<html>
    <head>
        <title>Sistem Saringan Talasemia (SST)</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/global.css" rel="stylesheet" type="text/css"/>
        <link href="font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <div id="xwrapper">
            <div id="xheader"></div>
            <div id="xmenu">
                <?= $this->render('menu', ['user'=>$user]) ?>
            </div>
            <div id="xbody">
                <?php echo $content; ?>
            </div>
            <div id="xfooter"></div>
        </div>
    </body>
</html>

