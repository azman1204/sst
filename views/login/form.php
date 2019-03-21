<!DOCTYPE html>
<html>
    <head>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <script src="jquery-3.2.1.min.js"></script>
    </head>
    <body>
    <div style='margin-top:200px'></div>
        <form method="post" action="index.php?r=login/auth">
        <div class='row'>
            <div class="col-md-4"></div>
            <div class='col-md-4'>
                <img src='images/logo.png'>
                <legend>Sistem Saringan Talasemia (SST)</legend>
                <hr>
                <!-- <img src='images/login.png'> -->
                <?php
                if (\Yii::$app->session->hasFlash('err')) {
                    echo "<div class='alert alert-danger'>";
                    echo \Yii::$app->session->getFlash('err');
                    echo "</div>";
                }
                ?>
                <div class='container mt-2'>
                    <div class="row">
                        <div class="col">ID Pengguna</div>
                    </div>
                    <div class="row">
                        <div class="col"><input type="text" name="user_id" class="form-control"></div>
                    </div>
                    <div class="row">
                        <div class="col">Katalaluan</div>
                    </div>
                    <div class="row">
                        <div class="col"><input type="password" name="pwd" class="form-control"></div>
                    </div>
                    <div class="row">
                        <div class="col"><input type="submit" value="Hantar" class="btn btn-primary"></div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="_csrf" value="<?=\Yii::$app->request->csrfToken?>">
            </div>
            </div>
        </form>

        <style>
            body {
                /*background-image: url(images/login-background.png);*/
            }
                
            .row {
                margin-top: 5px;
            }

            .container {
                margin: auto;
                margin-top: 100px;
                padding: 20px;
                background-color: #eee;
                border: 10px solid #999;
                opacity:0.7;
                border-radius: 15px;
            }

            legend {
                color: red;
                font-size:30px;
                font-weight:bold;
                text-shadow: 1px 2px #000;
            }
        </style>
    </body>
</html>
